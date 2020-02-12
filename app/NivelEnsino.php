<?php

namespace App;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NivelEnsino extends Model
{
    use UserCan;

    protected $table = 'niveis_ensino';
    protected $appends = ['user_can'];

    public function components()
    {
        return $this->hasMany(\App\CurricularComponent::class, 'nivel_id', 'id');
    }
}
