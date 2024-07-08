<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Clock_Record;
use Carbon\Carbon;

class Clock_RecordFactory extends Factory
{
    protected $model = Clock_Record::class;

    public function definition()
    {
        $date = $this->faker->dateTimeBetween('2024-06-24', '2024-06-25');
            $checkinTime = Carbon::instance($date)->setTime(rand(7, 10), rand(0, 59));
            $checkoutTime = (clone $checkinTime)->addMinutes(rand(240, 480));

        return [
            'user_id' => User::factory(),
            'checkin_time' => $checkinTime,
            'checkout_time' => $checkoutTime,
            'date' => $checkinTime->toDateString(),
        ];
    }
}
