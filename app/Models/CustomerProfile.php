<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $fillable = ['customer_id', 'first_name', 'last_name', 'email', 'phone', 'image', 'birthdate'];
    protected $hidden = [];
    protected $casts = ['birthdate' => 'datetime'];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthdate'])->age;
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
