<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Walkthrough;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

$factory->define(Walkthrough::class, function (Faker $faker) {
    $faker->addProvider(new Xvladqt\Faker\LoremFlickrProvider($faker));

    $filepath_walkthrough = public_path('storage/walkthrough');
    if (!File::exists($filepath_walkthrough)) {
        File::makeDirectory($filepath_walkthrough, 0777, true);
    }

    return [
        'image' => 'walkthrough/' . $faker->image($filepath_walkthrough, 720, 1520, ['technics'], false),
    ];
});
