<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait ShortTitle
{
    public function getShortTitleAttribute()
    {
        dd($this::class); 
    }
}
