<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelEnsino extends Model
{
    protected $table = 'niveis_ensino';
    
    public function components()
    {
        return $this->hasMany(\App\CurricularComponent::class, 'nivel_id', 'id');
    }
}
