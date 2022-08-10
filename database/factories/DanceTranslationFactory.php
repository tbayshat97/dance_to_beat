<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Dance;
use App\Models\DanceTranslation;
use Faker\Generator as Faker;

$factory->define(DanceTranslation::class, function (Faker $faker) {
    return [
        'dance_id' => factory(Dance::class)->create()->id,
        'locale' => 'en',
        'name' => $faker->words(rand(2, 4), true)
    ];
});
