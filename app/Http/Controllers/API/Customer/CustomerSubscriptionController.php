<?php

namespace App\Http\Controllers\API\Customer;

use App\Enums\CustomerSubscriptionStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerSubscription as ResourcesCustomerSubscription;
use App\Models\CustomerSubscription;
use App\Models\Subscription;
use App\Traits\ApiResponser;
use Carbon\Carbon;

class CustomerSubscriptionController extends Controller
{
    use ApiResponser;

    public function subscribe(Subscription $subscription)
    {
        $customerSubscription = CustomerSubscription::where('customer_id', auth()->user()->id)->first();

        switch (true) {
            case $customerSubscription && $customerSubscription->ends_at >= now():
                return $this->successResponse(403, trans('api.public.action_forbidden'), 200, new ResourcesCustomerSubscription($customerSubscription));
                break;
            case $customerSubscription && $customerSubscription->ends_at <= now():
                $customerSubscription->subscription_id = $subscription->id;
                $customerSubscription->ends_at = Carbon::now()->addMonths($subscription->month_count);
                $customerSubscription->status = CustomerSubscriptionStatus::Pending;
                $customerSubscription->save();

                return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomerSubscription($customerSubscription));
                break;
            default:
                $customerSubscription = new CustomerSubscription();
                $customerSubscription->subscription_id = $subscription->id;
                $customerSubscription->customer_id = auth()->user()->id;
                $customerSubscription->ends_at = Carbon::now()->addMonths($subscription->month_count);
                $customerSubscription->status = CustomerSubscriptionStatus::Pending;
                $customerSubscription->save();
                return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomerSubscription($customerSubscription));
                break;
        }
    }
}
