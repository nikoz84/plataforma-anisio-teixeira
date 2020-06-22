<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConteudoLike extends Model
{
   use SoftDeletes, UserCan;

    protected $table = 'conteudos_likes';

    protected $fillable = [
        'user_id',
        'conteudo_id',
        'aplicativo_id',
        'tipo',
        'like'
    ];


    public function like()
    {

    }

    public function deslike()
    {

    }
}