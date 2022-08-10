<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MainSlider extends JsonResource
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
            'main_slider_id' => $this->id,
            'main_slider_image' => asset('storage/' . $this->image),
            'main_slider_content' => $this->translateOrDefault()->content,
        ];
    }
}
