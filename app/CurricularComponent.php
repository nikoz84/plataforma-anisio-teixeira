<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CurricularComponent extends Model
{
    protected $table = 'curricular_components';
    protected $hidden = ['pivot'];
    protected $appends = ['icon'];

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
    public function getIconAttribute()
    {
        if ($this['nivel_id'] == 5) {
            return Storage::disk('public-path')->url("img/emitec/{$this['id']}.svg");
        }
    }
}
