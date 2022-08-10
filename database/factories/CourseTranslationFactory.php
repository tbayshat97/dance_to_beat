<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Course;
use App\Models\CourseTranslation;
use Faker\Generator as Faker;

$factory->define(CourseTranslation::class, function (Faker $faker) {
    return [
        'course_id' => factory(Course::class)->create()->id,
        'locale' => 'en',
        'title' => $faker->words(rand(2, 4), true),
        'description' => $faker->realText(rand(25, 50)),
    ];
});
