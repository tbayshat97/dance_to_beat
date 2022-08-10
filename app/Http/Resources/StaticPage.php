<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaticPage extends JsonResource
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
            'static_page_id' => $this->id,
            'static_page_key' => $this->key,
            'static_page_title' => $this->translateOrDefault()->title,
            'static_page_content' => $this->translateOrDefault()->content,
        ];
    }
}
