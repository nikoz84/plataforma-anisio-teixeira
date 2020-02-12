<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Conteudo;
use App\Aplicativo;
use App\Traits\UserCan;

class Tag extends Model
{
    use SoftDeletes, UserCan;

    const INIT_SEARCHED = 0;

    protected $fillable = ['name', 'searched'];
    protected $hidden = ['pivot'];
    protected $appends = ['user_can'];

    public function conteudos()
    {
        return $this->belongsToMany(Conteudo::class);
    }
    public function aplicativos()
    {
        return $this->belongsToMany(Aplicativo::class);
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
