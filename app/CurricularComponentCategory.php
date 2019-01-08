<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurricularComponentCategory extends Model
{
    protected $table = 'curricular_components_categories';

    public function components()
    {
        return $this->hasMany(\App\CurricularComponent::class, 'category_id', 'id');
    }
}
