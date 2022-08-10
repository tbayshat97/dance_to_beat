<?php

namespace App\Http\Resources;

use App\Http\Resources\Artist as ResourcesArtist;
use App\Models\Artist;
use Illuminate\Http\Resources\Json\JsonResource;

class Review extends JsonResource
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
            'review_id' => $this->id,
            'review_reviewable_type' => $this->reviewable_type === Artist::class ? ResourcesArtist::make($this->reviewable) : Course::make($this->reviewable),
            'review_reviewable_id' => $this->reviewable_id,
            'review_rate' => $this->rate,
            'review_note' => $this->note,
        ];
    }
}
