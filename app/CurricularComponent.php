<?php

namespace App;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CurricularComponent extends Model
{
    use UserCan;

    protected $table = 'curricular_components';
    protected $hidden = ['pivot'];
    protected $appends = ['icon', 'user_can', 'search_url'];

    public $fillable = ['name', 'category_id', 'nivel_id'];

    public function category()
    {
        return $this->belongsTo("App\CurricularComponentCategory", "category_id", "id");
    }

    public function niveis()
    {
        return $this->belongsTo("App\NivelEnsino", "nivel_id", "id");
    }


    public function categories()
    {
        return $this->hasMany('App\CurricularComponentCategory', 'id', 'category_id');
    }

    /**
     * Consulta as Niveis tem Muitos
     * @param \App\CurricularComponentes $curricular
     * @return \App\Model\ApiResponser retorna json
     */

    public function niveis()
    {
        return $this->hasMany('App\NivelEnsino', 'id', 'nivel_id');
    }
    
      /**
     * Funçao as Conteudos Pertence a  Muitos
     * @param \App\CurricularComponentes $curricular
     * @return \App\Model\ApiResponser retorna json
     */
    public function conteudos()
    {
        return $this->belongsToMany('App\Conteudo');
    }

     /**
     * Função Obtem um icone do Atributo
     * @param \App\CurricularComponentes $curricular
     * @return \App\Model\ApiResponser retorna json
     */

    public function getIconAttribute()
    {
        return "/img/sprite/" . Str::slug($this['name'], '-') . ".svg";
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
     /**
      * Função Obtem a pesquisa do Atributo
      * @param \App\CurricularComponentes $curricular
      * @return \App\Model\ApiResponser retorna json
      * @return void
      */
    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?componentes={$this['id']}";
    }
}
