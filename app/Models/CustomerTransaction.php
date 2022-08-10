<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerTransaction extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function transable()
    {
        return $this->morphTo();
    }
}
