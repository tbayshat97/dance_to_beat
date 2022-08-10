<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\NotificationType;
use App\Models\Customer;
use App\Models\CustomerNotification;
use Faker\Generator as Faker;

$factory->define(CustomerNotification::class, function (Faker $faker) {
    return [
        'customer_id' => Customer::inRandomOrder()->limit(1)->first()->id,
        'title' => $faker->sentence,
        'content' => $faker->realText(rand(25, 50)),
        'type' => NotificationType::getRandomValue(),
        'is_read' => false,
    ];
});
