<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerNotificationCollection;
use App\Models\CustomerNotification;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CustomerNotificationController extends Controller
{
    use ApiResponser;

    public function list()
    {
        $customer = auth()->user();
        $notifications = $customer->customerNotifications;
        return $this->successResponse(200, trans('api.public.done'), 200, new CustomerNotificationCollection($notifications));
    }

    public function deleteAll()
    {
        $customer = auth()->user();
        $customer->customerNotifications()->update(['is_deleted' => true]);
        return $this->successResponse(200, trans('api.public.done'), 200);
    }

    public function destroy(CustomerNotification $customerNotification)
    {
        if ($customerNotification->customer_id == auth()->user()->id) {
            $customerNotification->is_deleted = true;
            $customerNotification->save();
        }

        return $this->successResponse(200, trans('api.public.done'), 200);
    }

    public function receiveNotification(Request $request)
    {
        $customer = auth()->user();
        $customer->fcm_token = $request->device_id ? $request->device_id : null;
        $customer->save();
        return $this->successResponse(200, trans('api.public.done'), 200, null);
    }

    public function receiveNotificationSettings(Request $request)
    {
        $customer = auth()->user();
        $customerProfile = $customer->profile;

        if($request->has('noti_birthday'))
        {
            $customerProfile->noti_birthday = $request->noti_birthday;
        }

        if($request->has('noti_water'))
        {
            $customerProfile->noti_water = $request->noti_water;
            $customerProfile->remind_me_after_index = $request->remind_me_after_index;
            $customerProfile->remind_me_after_value = $request->remind_me_after_value;
        }

        if($request->has('noti_appointment_reminder'))
        {
            $customerProfile->noti_appointment_reminder = $request->noti_appointment_reminder;
        }

        if($request->has('noti_information_and_promo'))
        {
            $customerProfile->noti_information_and_promo = $request->noti_information_and_promo;
        }

        $customerProfile->save();

        return $this->successResponse(200, trans('api.public.done'), 200, null);
    }
}
