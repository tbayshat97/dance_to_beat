<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $casts = ['date' => 'datetime'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
