<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    public $timestamps = false;
    protected $fillable= ['name','options'];

    protected $casts = [
        'options' => 'array',
    ];
}
