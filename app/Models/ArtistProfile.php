<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ArtistProfile extends Model
{
    protected $fillable = ['customer_id', 'first_name', 'last_name', 'phone', 'image', 'gallery', 'birthdate'];
    protected $hidden = [];
    protected $casts = ['birthdate' => 'datetime'];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthdate'])->age;
    }

    public function getFullnameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function getProfileImage()
    {
        foreach (json_decode($this->image) as $value) {
            $image = asset('storage/' . $value->file);
        }
        return $image;
    }

    public function getProfileGallery()
    {
        $items = $this->gallery;

        if (!is_null($items)) {
            foreach (json_decode($items) as $value) {
                $gallery[] = asset('storage/' . $value->file);
            }
        }
        return $gallery;
    }

    public function dance()
    {
        return $this->belongsTo(Dance::class);
    }
}
