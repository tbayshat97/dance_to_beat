<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DialogMessage extends Model
{
    public function dialog()
    {
        return $this->belongsTo(Dialog::class);
    }

    public static function allAdminUnreadedMessagesCount()
    {
        return self::where(['is_read' => false, 'to_accountable_type' => User::class])->count();
    }
}
