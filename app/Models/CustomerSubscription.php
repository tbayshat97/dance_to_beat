<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSubscription extends Model
{
    protected $casts = ['trial_ends_at' => 'datetime', 'ends_at' => 'datetime'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }
}
