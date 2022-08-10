<?php

namespace App\Http\Resources;

use App\Models\Artist as ModelsArtist;
use Illuminate\Http\Resources\Json\JsonResource;

class Artist extends JsonResource
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
            'artist_id' => $this->id,
            'artist_username' => $this->username,
            'artist_courses' => Course::collection($this->courses),
            'artist_created_at' => $this->created_at->diffforhumans(),
            'artist_profile' => ArtistProfile::make($this->profile),
            'artist_reviews' => starRatingsCalculator(ModelsArtist::class, $this->id),
            'artist_courses' => Course::collection($this->courses),
            'artist_courses_count' => $this->courses()->count(),
        ];
    }
}
