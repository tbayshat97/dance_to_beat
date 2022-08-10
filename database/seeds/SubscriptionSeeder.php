<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscriptions_rows = [
            ['id' => 1, 'name' => '3 months', 'month_count' => 3,  'price' => 99],
            ['id' => 2, 'name' => '5 months', 'month_count' => 5,  'price' => 169],
            ['id' => 3, 'name' => 'Yearly', 'month_count' => 12,  'price' => 259],
        ];

        DB::table('subscriptions')->insert($subscriptions_rows);

        DB::table('subscriptions')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
