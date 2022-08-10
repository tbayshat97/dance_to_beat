<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Dance;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

$factory->define(Dance::class, function (Faker $faker) {
    $faker->addProvider(new Xvladqt\Faker\LoremFlickrProvider($faker));

    $filepath_dance = public_path('storage/dance');
    if (!File::exists($filepath_dance)) {
        File::makeDirectory($filepath_dance, 0777, true);
    }

    return [
        'image' => 'dance/' . $faker->image($filepath_dance, 600, 600, ['technics'], false),
        'is_active' => true,
    ];
});
