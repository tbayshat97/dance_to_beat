<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Walkthrough;
use App\Models\WalkthroughTranslation;
use Faker\Generator as Faker;

$factory->define(WalkthroughTranslation::class, function (Faker $faker) {
    return [
        'walkthrough_id' => factory(Walkthrough::class)->create()->id,
        'locale' => 'en',
        'title' => $faker->sentence,
        'content' => $faker->realText(rand(25, 50)),
    ];
});
