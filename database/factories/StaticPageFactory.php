<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StaticPage;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(StaticPage::class, function (Faker $faker) {
    return [
        'key' =>  Str::random(10)
    ];
});
