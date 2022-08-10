<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Walkthrough extends JsonResource
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
            'walkthrough_id' => $this->id,
            'walkthrough_image' => asset('storage/' . $this->image),
            'walkthrough_title' => $this->translateOrDefault()->title,
            'walkthrough_content' => $this->translateOrDefault()->content,
        ];
    }
}
