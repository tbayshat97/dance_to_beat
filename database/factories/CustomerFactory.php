<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(Customer::class, function (Faker $faker) {
    $phone = '96278' . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);

    return [
        'username' => $phone,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'account_verified_at' => now(),
        'is_blocked' => $faker->boolean(25),
        'fcm_token' => Str::uuid()->toString(),
        'remember_token' => Str::random(10),
    ];
});
