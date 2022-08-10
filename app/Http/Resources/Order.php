<?php

namespace App\Http\Resources;

use App\Enums\OrderStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $order_status = OrderStatus::fromValue($this->status);

        return [
            'order_id' => $this->id,
            'order_course' => Course::make($this->course),
            'order_order_number' => '#' . $this->order_number,
            'order_status' => [
                'key' => $order_status->key,
                'name' => $order_status->description,
                'value' => $order_status->value,
            ],
            'order_is_finished' => $this->is_finished,
            'order_created_at' => $this->created_at->format('Y-m-d'),
            'order_total_cost' => number_format($this->total_cost, 2),
        ];
    }
}
