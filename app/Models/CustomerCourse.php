<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCourse extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
