<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UserCan;

class Options extends Model
{
    use UserCan;

    protected $fillable = [
        'name',
        'meta_data',
    ];
    protected $appends = ['user_can'];
    protected $casts = [
        'meta_data' => 'array',
    ];
}
