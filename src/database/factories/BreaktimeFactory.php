<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Clock_Record;
use App\Models\Breaktime;
use Carbon\Carbon;

class BreaktimeFactory extends Factory
{
    protected $model = Breaktime::class;

    public function definition()
    {
        $clockRecord = Clock_Record::factory()->create();
        $startTime = Carbon::parse($clockRecord->checkin_time);
        $endTime = Carbon::parse($clockRecord->checkout_time);

        $breakStart = (clone $startTime)->addMinutes(rand(60, 180));
        $breakEnd = (clone $breakStart)->addMinutes(rand(15, 60));

        if ($breakEnd->greaterThan($endTime)) {
            $breakEnd = $endTime->copy()->subMinutes(rand(0, 15));
        }

        return [
            'clock_record_id' => $clockRecord->id,
            'start_time' => $breakStart,
            'end_time' => $breakEnd,
        ];
    }
}