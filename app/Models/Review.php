<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reviewable()
    {
        return $this->morphTo();
    }
}
