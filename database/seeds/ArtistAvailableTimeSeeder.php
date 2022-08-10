<?php

use App\Models\ArtistAvailableTime;
use Illuminate\Database\Seeder;

class ArtistAvailableTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ArtistAvailableTime::class, 100)->create();
    }
}
