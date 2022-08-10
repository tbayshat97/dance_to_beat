<?php

use App\Models\WalkthroughTranslation;
use Illuminate\Database\Seeder;

class WalkthroughSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(WalkthroughTranslation::class, 3)->create();
    }
}
