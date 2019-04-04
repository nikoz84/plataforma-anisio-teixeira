<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurricularComponent extends Model
{
    protected $table = 'curricular_components';
    protected $hidden = ['pivot'];

    public function categories()
    {
        return $this->hasMany('App\CurricularComponentCategory', 'id', 'category_id');
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