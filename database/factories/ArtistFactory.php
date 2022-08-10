<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\ArtistStatus;
use App\Models\Artist;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Artist::class, function (Faker $faker) {
    return [
        'username' => $faker->safeEmail,
        'password' => bcrypt('123456'),
        'account_verified_at' => now(),
        'is_blocked' => $faker->boolean(25),
        'fcm_token' => Str::uuid()->toString(),
        'remember_token' => Str::random(10),
        'status' => ArtistStatus::getRandomValue(),
    ];
});
