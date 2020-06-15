<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\FileSystemLogic;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\UserCan;
use Illuminate\Support\Facades\Auth;

class Comentario extends Model
{
    use SoftDeletes, UserCan;

    protected $table = 'comentarios';

    protected $fillable = [
        'user_id',
        'conteudo_id',
        'aplicativo_id',
        'body'
    ];
}