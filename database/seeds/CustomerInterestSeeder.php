<?php

use App\Models\CustomerInterest;
use Illuminate\Database\Seeder;

class CustomerInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CustomerInterest::class, 30)->create();
    }
}
