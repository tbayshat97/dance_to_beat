<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'account_verified_at' => now(),
        'remember_token' => Str::random(10),
    ];
});
