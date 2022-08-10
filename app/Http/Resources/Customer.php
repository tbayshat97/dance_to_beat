<?php

namespace App\Http\Resources;

use App\Enums\CustomerSubscriptionStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $socials = $this->socials->map(function ($item) {
            return $item->provider;
        });

        return [
            'customer_id' => $this->id,
            'customer_username' => $this->username,
            'customer_email' => $this->email,
            'customer_created_at' => $this->created_at->diffforhumans(),
            'customer_is_receive_notification' => $this->fcm_token ? true : false,
            'customer_profile' => CustomerProfile::make($this->profile),
            'customer_social' => $socials,
            'customer_interests' => $this->interests()->count() ? CustomerInterest::collection($this->interests) : [],
            'customer_courses' => CustomerCourse::collection($this->courses),
            'is_subscribed' => $this->subscription && $this->subscription->status === CustomerSubscriptionStatus::Paid  ? !$this->isExpired($this->subscription->ends_at) : false,
            'last_subscription' => $this->subscription && $this->subscription->status === CustomerSubscriptionStatus::Paid ? $this->subscription($this->subscription) : null,
        ];
    }

    protected function isExpired($endDate)
    {
        return $endDate <= now();
    }

    protected function subscription($subscription)
    {
        return [
            'name' => $subscription->package->name,
            'price' => $subscription->package->price,
            'end_date' => $subscription->ends_at->format('Y-m-d'),
            'status' => CustomerSubscriptionStatus::fromValue($subscription->status)->description
        ];
    }
}
