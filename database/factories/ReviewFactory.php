<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Artist;
use App\Models\Course;
use App\Models\Customer;
use App\Models\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    $reviewable_type = '';
    $reviewable_id = 0;

    $rand_to = rand(1, 2);

    switch ($rand_to) {
        case 1:
            $reviewable_type = Artist::class;
            $reviewable_id = Artist::all()->random()->id;
            break;
        case 2:
            $reviewable_type = Course::class;
            $reviewable_id = Course::all()->random()->id;
            break;
    }

    return [
        'customer_id' => Customer::inRandomOrder()->limit(1)->first()->id,
        'reviewable_type' => $reviewable_type,
        'reviewable_id' => $reviewable_id,
        'rate' => rand(1, 5),
        'note' => $faker->realText(75),
    ];
});
