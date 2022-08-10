<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Dance extends JsonResource
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
            'dance_id' => $this->id,
            'dance_name' => $this->translateOrDefault()->name,
            'dance_image' => ($this->image) ? asset('storage/' . $this->image) : null,
            'dance_is_active' => $this->is_active,
        ];
    }
}
