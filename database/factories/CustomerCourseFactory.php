<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Course;
use App\Models\Customer;
use App\Models\CustomerCourse;
use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(CustomerCourse::class, function (Faker $faker) {
    return [
        'customer_id' => Customer::inRandomOrder()->limit(1)->first()->id,
        'course_id' => Course::inRandomOrder()->limit(1)->first()->id,
        'order_id' => Order::inRandomOrder()->limit(1)->first()->id,
    ];
});
