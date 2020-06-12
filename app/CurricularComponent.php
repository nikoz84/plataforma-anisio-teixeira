<?php

namespace App;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CurricularComponent extends Model
{
    use UserCan;

    protected $table = 'curricular_components';
    protected $hidden = ['pivot'];
    protected $appends = ['icon', 'user_can', 'search_url'];

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
        return Str::slug($this['name'], '-');
        /*
        $icone = null;
        if ($this['nivel_id'] == 5) {
            $icone = Storage::disk('public-path')->url("img/emitec/{$slug}.svg");
        } elseif ($this['category_id'] == 3) {
            $icone = Storage::disk('public-path')->url("img/temas-transversais/{$slug}.svg");
        }

        return $icone;
        */
    }
    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?componentes={$this['id']}";
    }
}
