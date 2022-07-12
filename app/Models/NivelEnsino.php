<?php

namespace App\Models;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Canal;
use App\Models\CurricularComponent;

class NivelEnsino extends Model
{
    use UserCan;
    /**Tabela com campo definido */
    protected $table = 'niveis_ensino';
    /* sem data criação, atualização */
    public $timestamps = false;
    /**Tabela com campos definidos */
    protected $appends = ['user_can', 'search_url'];
    /**Tabela com campos definidos */
    protected $fillable = ['name'];

    /**
     * Função Retorna Componentes tem muitos
     * @param \App\NivelEnsino $nivelEnsion
     * @return \App\Model\ApiResponser retorna json
     */
    public function componentes()
    {
        return $this->hasMany(CurricularComponent::class, 'nivel_id', 'id');
    }
    /**
     * Função Faz uma pesquisa do Atributo pela Url
     *@param \App\NivelEnsino $nivelEnsion
     * @return \App\Model\ApiResponser retorna json
     */
    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?nivel_id={$this['id']}";
    }
}