<?php

use App\Models\CourseProgress;
use Illuminate\Database\Seeder;

class CourseProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CourseProgress::class, 100)->create();
    }
}
