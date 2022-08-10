<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    protected $fillable = ['updated_at'];

    public function messages()
    {
        return $this->hasMany(DialogMessage::class);
    }

    public function unreadMessages()
    {
        return $this->hasMany(DialogMessage::class)->where('is_read', false)->count();
    }
}
