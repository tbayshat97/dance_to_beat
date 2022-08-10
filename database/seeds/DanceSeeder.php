<?php

use App\Models\DanceTranslation;
use Illuminate\Database\Seeder;

class DanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DanceTranslation::class, 12)->create();
    }
}
