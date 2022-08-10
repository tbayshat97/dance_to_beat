<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Artist;
use App\Models\Customer;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    return [
        'customer_id' => Customer::all()->random()->id,
        'artist_id' => Artist::all()->random()->id,
        'date' => Carbon::now()->addDays(rand(1, 100)),
        'status' => AppointmentStatus::getRandomValue(),
        'total_cost' => $faker->randomFloat(1, 25, 130)
    ];
});
