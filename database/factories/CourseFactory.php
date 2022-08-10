<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\CourseAccessType;
use App\Enums\CourseLevel;
use App\Enums\CourseType;
use App\Enums\VideoType;
use App\Models\Artist;
use App\Models\Course;
use App\Models\Dance;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

$factory->define(Course::class, function (Faker $faker) {
    $faker->addProvider(new Xvladqt\Faker\LoremFlickrProvider($faker));

    $filepath_course = public_path('storage/course');
    if (!File::exists($filepath_course)) {
        File::makeDirectory($filepath_course, 0777, true);
    }

    $imagePath = 'course/' . $faker->image($filepath_course, 600, 600, ['technics'], false);

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

    return [
        'dance_id' => Dance::inRandomOrder()->limit(1)->first()->id,
        'artist_id' => Artist::inRandomOrder()->limit(1)->first()->id,
        'price' => $price,
        'image' => json_encode([$image]),
        'gallery' => json_encode([$image]),
        'duration' => rand(50, 200),
        'start_at' => Carbon::now(),
        'expire_at' => Carbon::now()->addYear(),
        'course_level' => CourseLevel::getRandomValue(),
        'video_type' => VideoType::Vimeo,
        'is_published' => true,
        'video' => 'https://dance2beat.qiotic.info/admin',
        'promo_video' => 'https://dance2beat.qiotic.info/admin',
    ];
});
