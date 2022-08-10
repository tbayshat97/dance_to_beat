<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Course extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes = ['title', 'description'];
    protected $casts = ['start_at' => 'datetime', 'expire_at' => 'datetime'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function dance()
    {
        return $this->belongsTo(Dance::class);
    }

    public function getCourseImage()
    {
        foreach (json_decode($this->image) as $value) {
            $image = asset('storage/' . $value->file);
        }
        return $image;
    }

    public function getCourseGallery()
    {
        $items = $this->gallery;

        if (!is_null($items)) {
            foreach (json_decode($items) as $value) {
                $gallery[] = asset('storage/' . $value->file);
            }
        }
        return $gallery;
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favourable');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function live()
    {
        return $this->hasOne(LiveCourse::class);
    }
}
