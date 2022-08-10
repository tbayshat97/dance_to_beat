<?php

use App\Models\CustomerNotification;
use Illuminate\Database\Seeder;

class CustomerNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CustomerNotification::class, 100)->create();
    }
}
