<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StaticPage;
use App\Models\StaticPageTranslation;
use Faker\Generator as Faker;

$factory->define(StaticPageTranslation::class, function (Faker $faker) {
    return [
        'static_page_id' => factory(StaticPage::class)->create()->id,
        'locale' => 'en',
        'title' => $faker->sentence,
        'content' => $faker->realText(rand(25, 50)),
    ];
});
