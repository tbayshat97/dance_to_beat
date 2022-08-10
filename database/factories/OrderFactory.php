<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\OrderStatus;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Customer;
use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $customer = Customer::inRandomOrder()->limit(1)->first()->id;
    $course = Course::inRandomOrder()->limit(1)->first();

    return [
        'order_number' => date('ymd') . $customer . strtoupper(substr(uniqid(sha1(time())), 0, 9)),
        'customer_id' => $customer,
        'course_id' => $course->id,
        'coupon_id' => $faker->boolean(50) ? Coupon::inRandomOrder()->limit(1)->first()->id : null,
        'status' => OrderStatus::getRandomValue(),
        'total_cost' => $course->price
    ];
});
