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

    public function componentes()
    {
        return $this->hasMany(\App\CurricularComponent::class, 'nivel_id', 'id');
    }
    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?nivel_id={$this['id']}";
    }
}
