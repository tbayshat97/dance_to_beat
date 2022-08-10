<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Subscription extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'subscription_id' => $this->id,
            'subscription_name' => $this->name,
            'subscription_price' => $this->price,
            'subscription_description' => $this->description,
        ];
    }
}
