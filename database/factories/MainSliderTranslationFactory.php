<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MainSlider;
use App\Models\MainSliderTranslation;
use Faker\Generator as Faker;

$factory->define(MainSliderTranslation::class, function (Faker $faker) {
    return [
        'main_slider_id' => factory(MainSlider::class)->create()->id,
        'locale' => 'en',
        'content' => $faker->realText(rand(25, 50)),
    ];
});
