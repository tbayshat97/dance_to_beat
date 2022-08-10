<?php

namespace App\Http\Resources;

use App\Enums\GenderTypes;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistProfile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $gender = $this->gender ? GenderTypes::fromValue($this->gender) : null;

        $genderData = $gender ? [
            'key' => $gender->key,
            'name' => $gender->description,
            'value' => $gender->value,
        ] : null;

        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthdate' => $this->birthdate ?  $this->birthdate->format('Y-m-d') : null,
            'image' => $this->getProfileImage(),
            'gallery' => $this->getProfileGallery(),
            'gender' => $genderData,
            'bio' => $this->bio,
            'phone' => $this->phone,
            'price_per_hour' => $this->price_per_hour,
            'percentage' => $this->percentage,
            'dance' => Dance::make($this->dance),
        ];
    }
}
