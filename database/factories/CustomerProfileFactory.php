<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\GenderTypes;
use App\Models\CustomerProfile;
use App\Models\Customer;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

$factory->define(CustomerProfile::class, function (Faker $faker) {
    $faker->addProvider(new Xvladqt\Faker\LoremFlickrProvider($faker));

    $filepath = public_path('storage/customer');
    if (!File::exists($filepath)) {
        File::makeDirectory($filepath, 0777, true);
    }

    return [
        'customer_id' => factory(Customer::class)->create()->id,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'image' => $faker->boolean(75) ? 'customer/' . $faker->image($filepath, 600, 600, ['technics'], false) : null,
        'birthdate' => ($faker->boolean(50)) ? $faker->date() : null,
        'gender' => ($faker->boolean(50)) ? GenderTypes::getRandomValue() : null,
    ];
});
