<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Denuncia extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'url', 'subject', 'message', 'action'];
}
