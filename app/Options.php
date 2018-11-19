<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $fillable = [
        'id',
        'name',
        'meta_data'
        ];
    
    protected $casts = [
            'meta_data' => 'array',
    ];
}
