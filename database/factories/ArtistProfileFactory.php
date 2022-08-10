<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\GenderTypes;
use App\Models\Artist;
use App\Models\ArtistProfile;
use App\Models\Dance;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

$factory->define(ArtistProfile::class, function (Faker $faker) {
    $faker->addProvider(new Xvladqt\Faker\LoremFlickrProvider($faker));

    $filepath_artist = public_path('storage/artist');
    if (!File::exists($filepath_artist)) {
        File::makeDirectory($filepath_artist, 0777, true);
    }

    $imagePath = 'artist/' . $faker->image($filepath_artist, 600, 600, ['person'], false);

    $image = [
        'file' => $imagePath,
        'name' => 'Seeder',
        'size' => 41638,
        'local' => $imagePath,
        'type' => 'image/jpeg',
        'data' => [
            'url' => $imagePath,
            'thumbnail' => $imagePath,
            'readerForce' => true
        ],
    ];

    $price = $faker->randomFloat(1, 25, 130);

    $phone = '96278' . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);

    return [
        'artist_id' => factory(Artist::class)->create()->id,
        'dance_id' => Dance::inRandomOrder()->limit(1)->first()->id,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $phone,
        'birthdate' => ($faker->boolean(50)) ? $faker->date() : null,
        'gender' => GenderTypes::getRandomValue(),
        'bio' => $faker->realText,
        'image' => json_encode([$image]),
        'gallery' => json_encode([$image]),
        'price_per_hour' => $price,
        'percentage' => $faker->unique()->numberBetween(1, 100)
    ];
});
