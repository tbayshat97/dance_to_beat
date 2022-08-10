<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerInterestAdd;
use App\Models\CustomerInterest;
use App\Traits\ApiResponser;

class CustomerInterestController extends Controller
{
    use ApiResponser;

    public function store(CustomerInterestAdd $request)
    {
        $customer = auth()->user();

        foreach ($request->dances as $dance) {
            $customerInterest = new CustomerInterest();
            $customerInterest->customer_id = $customer->id;
            $customerInterest->dance_id = $dance;
            $customerInterest->save();
        }

        return $this->successResponse(200, trans('api.public.done'), 200);
    }
}
