<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Artist;
use App\Models\ArtistAvailableTime;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(ArtistAvailableTime::class, function (Faker $faker) {


    $today = (new Carbon)->parse(Carbon::now()->format('Y-m-d'));
    $sixMonthsAgo = Carbon::now()->addMonths(6);

    // How many days between two dates
    $diffInDays = $sixMonthsAgo->diffInDays($today);

    // Get a random number in the range of $diffInDays
    $randomDays = rand(0, $diffInDays);

    //add that many days to $today
    $randomDate = $today->addDays($randomDays);

    return [
        'artist_id' => Artist::inRandomOrder()->limit(1)->first()->id,
        'date' => $randomDate,
        'time' => rand(0, 23) . ":" . str_pad(rand(0, 59), 2, "0", STR_PAD_LEFT)
    ];
});
