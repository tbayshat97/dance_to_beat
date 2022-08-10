<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use App\Models\CustomerInterest;
use App\Models\Dance;
use Faker\Generator as Faker;

$factory->define(CustomerInterest::class, function (Faker $faker) {
    return [
        'customer_id' => Customer::inRandomOrder()->limit(1)->first()->id,
        'dance_id' => Dance::inRandomOrder()->limit(1)->first()->id,
    ];
});
