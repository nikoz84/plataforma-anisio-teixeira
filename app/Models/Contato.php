<?php

namespace App\Models;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contato extends Model
/**
 * Metodos Protegidos
 */
{
    use SoftDeletes, UserCan;

    protected $fillable = ['name', 'email', 'url', 'subject', 'message', 'action'];
    protected $appends = ['user_can'];
}
