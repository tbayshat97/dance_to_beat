<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Coupon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Coupon::class, function (Faker $faker) {
    return [
        'code' => Str::random(12),
        'start_at' => date('Y-m-1 00:00:00'),
        'end_at' => date('Y-m-25 23:59:59'),
        'percentage' => $faker->numberBetween(1, 12),
        'expire_count' => $faker->numberBetween(5, 100),
        'is_active' => $faker->randomElement([true, false]),
    ];
});
