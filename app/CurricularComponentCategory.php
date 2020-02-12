<?php

namespace App;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;

class CurricularComponentCategory extends Model
{
    use UserCan;

    protected $table = 'curricular_components_categories';
    protected $appends = ['user_can'];

    public function components()
    {
        return $this->hasMany(\App\CurricularComponent::class, 'category_id', 'id');
    }
}
