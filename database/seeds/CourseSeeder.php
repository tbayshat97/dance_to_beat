<?php

use App\Models\CourseTranslation;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CourseTranslation::class, 30)->create();
    }
}
