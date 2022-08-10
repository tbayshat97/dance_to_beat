<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\CourseProgressStatus;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(CourseProgress::class, function (Faker $faker) {

    $course = Course::inRandomOrder()->limit(1)->first();

    $getRandomWatchedDuration = rand(0, $course->duration);
    $getPrcentageOfWatched = get_percentage($course->duration, $getRandomWatchedDuration);

    return [
        'customer_id' => Customer::inRandomOrder()->limit(1)->first()->id,
        'course_id' => $course->id,
        'duration' => $getRandomWatchedDuration,
        'progress' => $getPrcentageOfWatched,
        'status' => $getPrcentageOfWatched == 100 ? CourseProgressStatus::Completed : CourseProgressStatus::Pending
    ];
});
