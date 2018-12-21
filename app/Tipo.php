<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $fillable= ['name','options'];

    protected $casts = [
        'options' => 'array',
    ];
    protected $attributes = [
        'options' => [],
    ];
}
