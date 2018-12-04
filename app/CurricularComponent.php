<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurricularComponent extends Model
{
    protected $table = 'curricular_components';
    
    public function categories()
    {
        return $this->hasMany('App\CurricularComponentCategory', 'id', 'category_id')->groupBy(['id','name']);
    }
    public function niveis()
    {
        return $this->hasMany('App\NivelEnsino', 'id', 'nivel_id');
    }

    public function conteudos()
    {
        return $this->belongsToMany('App\Conteudo');
    }
}
