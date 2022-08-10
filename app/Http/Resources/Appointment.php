<?php

namespace App\Http\Resources;

use App\Enums\AppointmentStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Appointment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $appointment_status = AppointmentStatus::fromValue($this->status);

        return [
            'appointment_id' => $this->id,
            'artist_details' => Artist::make($this->artist),
            'appointment_status' => [
                'key' => $appointment_status->key,
                'name' => $appointment_status->description,
                'value' => $appointment_status->value,
            ],
            'date' => Carbon::parse($this->date)->format('Y-m-d'),
            'hour' => Carbon::parse($this->date)->format('h:i A'),
            'day' => Carbon::parse($this->date)->format('l'),
            'total_cost' => $this->total_cost
        ];
    }
}
