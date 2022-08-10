<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveCourse extends Model
{
    protected $casts = ['start_at' => 'datetime'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
