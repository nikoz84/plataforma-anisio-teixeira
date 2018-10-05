<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable= ['name','searched'];

    public function conteudos(){
        return $this->belongsToMany('App\Conteudo');
    }
    public function aplicativos(){
        return $this->belongsToMany('App\Aplicativos');
    }
}
