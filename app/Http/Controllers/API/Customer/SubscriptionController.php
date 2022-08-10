<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionCollection;
use App\Models\Subscription;
use App\Traits\ApiResponser;

class SubscriptionController extends Controller
{
    use ApiResponser;

    public function list()
    {
        $subscriptions = Subscription::all();
        return $this->successResponse(200, trans('api.public.done'), 200, new SubscriptionCollection($subscriptions));
    }
}
