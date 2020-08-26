<?php

namespace App;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CurricularComponentCategory extends Model
{
    use UserCan;

    protected $table = 'curricular_components_categories';
    protected $appends = ['user_can', 'search_url'];
<<<<<<< HEAD
     
    /**
     * Função Componentes tem Muitos
     * @param \App\CurricularComponentCategory $curricularComponentCategory
     * @return \App\Model\ApiResponser retorna json
=======
    public $fillable = ['name'];

    /**
     * obtem os componetes relacionados a este componente
     * @return Illuminate\Database\Eloquent\Concerns\HasMany
>>>>>>> 59fafea095472a7b96e5e8137d18ca03da6dc9ba
     */
    public function componentes()
    {
        return $this->hasMany(\App\CurricularComponent::class, 'category_id', 'id');
    }
<<<<<<< HEAD
     /**
     * Função Obtém a Pesquisa do Atribuito pela URL
     * @param \App\CurricularComponentCategory $curricularComponentCategory
     * @return \App\Model\ApiResponser retorna json
=======
    
    /**
     * obtem string url de busca de eatributos da cateroria do componente
     * @return string
>>>>>>> 59fafea095472a7b96e5e8137d18ca03da6dc9ba
     */
    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?cc_category_id={$this['id']}";
    }
}
