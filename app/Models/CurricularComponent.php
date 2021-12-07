<?php

namespace App\Models;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\CurricularComponentCategory;
use App\Models\NivelEnsino;
use App\Models\Conteudo;

class CurricularComponent extends Model
{
    use UserCan;
    /**Tabela com Campo definido */
    protected $table = 'curricular_components';
    /**Tabela com campo definido */
    protected $hidden = ['pivot'];
    /**Tabela com campos definidos */
    protected $appends = ['icon', 'user_can', 'search_url'];
    /**Tabela com campos definidos */
    public $fillable = ['name', 'category_id', 'nivel_id'];
    /**
     * Método Categoria
     * @param void
     * @return belongsTo pertence a CurricularComponentCategory
     */
    public function category()
    {
        return $this->belongsTo(CurricularComponentCategory::class, "category_id", "id");
    }
    /**
     * Método Nível
     * @param void
     * @return belongsTo pertence a Nivel de Ensino
     */
    public function nivel()
    {
        return $this->belongsTo(NivelEnsino::class,"nivel_id", "id");
    }
    
    /**
     * Funçao as Conteudos Pertence a  Muitos
     * @param \App\Models\CurricularComponent $curricular
     * @return \App\Model\ApiResponser retorna json
     */
    public function conteudos()
    {
        return $this->belongsToMany(Conteudo::class);
    }
    /**
     * Função que aciona os atributos do icone
     * @param void
     * @return string e img
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
      * @param \App\Models\CurricularComponentes $curricular
      * @return \App\Traits\ApiResponser retorna json
      * @return void
      */
    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?componentes={$this['id']}";
    }
}
