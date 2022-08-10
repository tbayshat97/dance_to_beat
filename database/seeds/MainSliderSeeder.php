<?php

use App\Models\MainSliderTranslation;
use Illuminate\Database\Seeder;

class MainSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MainSliderTranslation::class, 1)->create();
    }
}
