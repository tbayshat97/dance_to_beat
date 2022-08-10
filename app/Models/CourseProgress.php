<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
