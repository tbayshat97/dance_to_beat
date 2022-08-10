<?php

namespace App\Http\Resources;

use App\Enums\CustomerSubscriptionStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerSubscription extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = CustomerSubscriptionStatus::fromValue($this->status);

        return [
            'customer_subscription_id' => $this->id,
            'customer_subscription_package' => Subscription::make($this->package),
            'customer_subscription_ends_at' => $this->ends_at,
            'customer_subscription_status' => [
                'key' => $status->key,
                'name' => $status->description,
                'value' => $status->value,
            ],
        ];
    }
}
