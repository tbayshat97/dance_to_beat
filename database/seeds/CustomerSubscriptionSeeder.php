<?php

use App\Models\Customer;
use App\Models\CustomerSubscription;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CustomerSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $customers = Customer::all();

        foreach ($customers as $customer) {
            $customerSubscription = new CustomerSubscription();
            $customerSubscription->subscription_id = 3;
            $customerSubscription->customer_id = $customer->id;
            $customerSubscription->ends_at = Carbon::now()->addYear();
            $customerSubscription->save();
        }
    }
}
