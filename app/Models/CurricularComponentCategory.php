<?php

namespace App\Models;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\CurricularComponent;
use App\Models\Canal;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CurricularComponentCategory extends Model
{
    use UserCan;

    protected $table = 'curricular_components_categories';
    protected $fillable = ['name'];
    protected $appends = ['user_can', 'search_url'];
     
    /**
     * Função Componentes tem Muitos
     * @param \App\CurricularComponentCategory $curricularComponentCategory
     * @return \App\Model\ApiResponser retorna jso
     * obtem os componetes relacionados a este componente
     * @return Illuminate\Database\Eloquent\Concerns\HasMany
     */
    public function componentes()
    {
        return $this->hasMany(CurricularComponent::class, 'category_id', 'id');
    }

     /**
     * Função Obtém a Pesquisa do Atribuito pela URL
     * obtem string url de busca de eatributos da cateroria do componente
     * @return string
     */

     public function searchUrl(): Attribute{
         $get = function(){
             $canal = Canal::find(6);
             if($canal){
                 return "/{$canal->slug}/listar?cc_category_id={$this['id']}";
             }
             return null;
         };
         return new Attribute(
             get: $get
         );
     }
}
