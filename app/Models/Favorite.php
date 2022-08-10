<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function favourable()
    {
        return $this->morphTo();
    }
}
