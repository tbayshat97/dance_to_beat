<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Artist  extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

    protected $fillable = ['username', 'password', 'status', 'is_blocked','percentage'];
    protected $hidden = ['password', 'remember_token'];
    protected $guard = 'artist';

    public function profile()
    {
        return $this->hasOne(ArtistProfile::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favourable');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function availableTimes()
    {
        return $this->hasMany(ArtistAvailableTime::class);
    }
}
