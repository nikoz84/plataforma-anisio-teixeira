<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NivelEnsino extends Model
{
    protected $table = 'niveis_ensino';
    protected $appends = [];

    public function components()
    {
        return $this->hasMany(\App\CurricularComponent::class, 'nivel_id', 'id');
    }
}
