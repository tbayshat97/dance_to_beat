<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Customer extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

    protected $fillable = ['username', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['account_verified_at' => 'datetime'];

    public function profile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function findForPassport($username)
    {
        return $this->where([
            ['username', '=', $username],
            ['account_verified_at', '!=', null],
        ])->first();
    }

    public function customerNotifications()
    {
        return $this->hasMany(CustomerNotification::class)->where('is_deleted', false)->orderBy('created_at', 'desc');
    }

    public function socials()
    {
        return $this->hasMany(CustomerProvider::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function paymentCards()
    {
        return $this->hasMany(CustomerPaymentCard::class);
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    public function interests()
    {
        return $this->hasMany(CustomerInterest::class);
    }

    public function favoriteArtists()
    {
        return $this->hasMany(Favorite::class)->where(['favourable_type' => Artist::class]);
    }

    public function favoriteCourses()
    {
        return $this->hasMany(Favorite::class)->where(['favourable_type' => Course::class]);
    }

    public function artistsReviews()
    {
        return $this->hasMany(Review::class)->where(['reviewable_type' => Artist::class]);
    }

    public function coursesReviews()
    {
        return $this->hasMany(Review::class)->where(['reviewable_type' => Course::class]);
    }

    public function subscription()
    {
        return $this->hasOne(CustomerSubscription::class, 'customer_id');
    }

    public function courses()
    {
        return $this->hasMany(CustomerCourse::class)->whereHas('order', function ($query) {
            $query->where('status', OrderStatus::Paid);
            $query->where('is_finished', true);
        });
    }

    public function progresses()
    {
        return $this->hasMany(CourseProgress::class);
    }
}
