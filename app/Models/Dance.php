<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Dance extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes = ['name', 'content'];
}
