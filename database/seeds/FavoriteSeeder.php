<?php

use App\Models\Artist;
use App\Models\Course;
use App\Models\Customer;
use App\Models\Favorite;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::all();
        $courses = Course::inRandomOrder()->limit(5)->get();
        $artists = Artist::inRandomOrder()->limit(5)->get();

        foreach ($customers as $customer) {
            foreach ($courses as $course) {
                $favorite = new Favorite();
                $favorite->customer_id = $customer->id;
                $favorite->favourable_type = Course::class;
                $favorite->favourable_id  = $course->id;
                $favorite->save();
            }

            foreach ($artists as $artist) {
                $favorite = new Favorite();
                $favorite->customer_id = $customer->id;
                $favorite->favourable_type = Artist::class;
                $favorite->favourable_id  = $artist->id;
                $favorite->save();
            }
        }
    }
}
