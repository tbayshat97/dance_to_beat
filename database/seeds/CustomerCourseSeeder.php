<?php

use App\Models\CustomerCourse;
use Illuminate\Database\Seeder;

class CustomerCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CustomerCourse::class, 30)->create();
    }
}
