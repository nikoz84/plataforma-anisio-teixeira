<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserCan;

class ContentPaginaInicial extends Model


/**
 * Metodos Protegidos
 */
{
    use SoftDeletes, UserCan;
    /**Tabela com campos definidos */
    public $timestamps = false;
    protected $table = 'content_pagina_inicial';
    protected $fillable = ['conteudo'];
    /**Tabela com campo definido */
    protected $appends = ['user_can'];
}
