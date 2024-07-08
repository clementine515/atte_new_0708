<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clock_Record;
use App\Models\Breaktime;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClockRecordController extends Controller
{
    public function index(Request $request)
    {
        $activeButton = 'checkin';
        $isStarted = $request->session()->get('is_started', false);
        return view('timestamp', ['isStarted' => $isStarted]);
    }

    public function checkin(Request $request)
    {
        $existingCheckin = Clock_Record::where('user_id', Auth::id())
                                    ->whereDate('checkin_time', today())
                                    ->exists();

        if (!$existingCheckin) {
            Clock_Record::create([
                'user_id' => Auth::id(),
                'checkin_time' => now(),
                'checkout_time' => null,
                'date'=> today()
            ]);
            $request->session()->put('is_started', true);
        }

        return redirect()->route('home');
    }

    public function checkout(Request $request)
    {
        $record = Clock_Record::where('user_id', Auth::id())
                        ->whereDate('checkin_time', today())
                        ->whereNotNull('checkout_time')
                        ->exists();

        if (!$record) {
            $existingCheckin = Clock_Record::where('user_id', Auth::id())
                                            ->whereDate('checkin_time', today())
                                            ->whereNull('checkout_time')
                                            ->first();

            if ($existingCheckin) {
                $existingCheckin->update([
                    'checkout_time' => now()
                ]);
            }
        }

        return redirect()->route('home');
    }

    public function start(Request $request)
    {
        Breaktime::create([
            'clock_record_id' => Auth::id(),
            'start_time' => now(),
            'end_time' => null
        ]);

        return redirect()->route('home');
    }

    public function end(Request $request)
    {
        $record = Breaktime::where('clock_record_id', Auth::id())
                    ->whereNull('end_time')
                    ->orderBy('start_time', 'desc')
                    ->firstOrFail();
        $record->update([
            'end_time' => now()
        ]);

        return redirect()->route('home');
    }

    public function date_index(Request $request)
    {
        $selectedDate = $request->input('date', Carbon::today()->toDateString());
        $clockRecords = Clock_Record::whereDate('date', $selectedDate)
                                    ->with('user', 'breaktimes')
                                    ->paginate(5);

        foreach ($clockRecords as $record) {
            $totalBreakTime = 0;

            foreach ($record->breaktimes as $break) {
                $breakStart = Carbon::parse($break->start_time);
                $breakEnd = Carbon::parse($break->end_time);
                $totalBreakTime += $breakStart->diffInMinutes($breakEnd);
            }

            $startTime = Carbon::parse($record->checkin_time);
            $endTime = Carbon::parse($record->checkout_time);
            $totalWorkTime = $startTime->diffInMinutes($endTime);
            $actualWorkTime = $totalWorkTime - $totalBreakTime;

            $record->total_break_time = $totalBreakTime;
            $record->actual_work_time = $actualWorkTime;
        }

        return view('date', [
            'clockRecords' => $clockRecords,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function showRecords($userId)
    {
        $user = User::findOrFail($userId);

        $clockRecords = Clock_Record::where('user_id', $userId)
                                    ->with('breaktimes')
                                    ->paginate(5);

        foreach ($clockRecords as $record) {
            $totalBreakTime = 0;

            foreach ($record->breaktimes as $break) {
                $breakStart = Carbon::parse($break->start_time);
                $breakEnd = Carbon::parse($break->end_time);
                $totalBreakTime += $breakStart->diffInMinutes($breakEnd);
            }

            $startTime = Carbon::parse($record->checkin_time);
            $endTime = Carbon::parse($record->checkout_time);
            $totalWorkTime = $startTime->diffInMinutes($endTime);
            $actualWorkTime = $totalWorkTime - $totalBreakTime;

            $record->total_break_time = $totalBreakTime;
            $record->actual_work_time = $actualWorkTime;
        }

        return view('users.rescords_each', [
            'user' => $user,
            'clockRecords' => $clockRecords,
        ]);
    }
}