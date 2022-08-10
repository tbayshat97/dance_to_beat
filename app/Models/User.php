<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens, HasRoles;

    protected $fillable = ['username', 'password'];
    protected $guard = 'admin';
    protected $guard_name = 'admin';
    protected $hidden = ['password'];
    protected $casts = ['account_verified_at' => 'datetime'];

    public function verifications()
    {
        return $this->morphMany(Verification::class, 'accountable')->orderBy('id', 'desc');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function findForPassport($username)
    {
        return $this->where([
            ['username', '=', $username],
            ['account_verified_at', '!=', null],
        ])->first();
    }
    
}
