<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInterest extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function dance()
    {
        return $this->belongsTo(Dance::class);
    }
}
