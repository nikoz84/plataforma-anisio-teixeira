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

    public function components()
    {
        return $this->hasMany(\App\CurricularComponent::class, 'category_id', 'id');
    }
    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?cc_category_id={$this['id']}";
    }
}
