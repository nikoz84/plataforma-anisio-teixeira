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
    public $fillable = ['name'];

    /**
     * obtem os componetes relacionados a este componente
     * @return Illuminate\Database\Eloquent\Concerns\HasMany
     */
    public function componentes()
    {
        return $this->hasMany(\App\CurricularComponent::class, 'category_id', 'id');
    }
    
    /**
     * obtem string url de busca de eatributos da cateroria do componente
     * @return string
     */
    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?cc_category_id={$this['id']}";
    }
}
