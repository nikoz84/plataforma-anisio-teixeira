<?php

namespace App;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NivelEnsino extends Model
{
    use UserCan;

    protected $table = 'niveis_ensino';
    protected $appends = ['user_can', 'search_url'];
    protected $fillable = ['name'];

    /**
     * Função Retorna Componentes tem muitos
     * @param \App\NivelEnsino $nivelEnsion
     * @return \App\Model\ApiResponser retorna json
     */
    public function componentes()
    {
        return $this->hasMany(\App\CurricularComponent::class, 'nivel_id', 'id');
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
