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
    /**
     * Relação de tag com tabela conteudos
     */
    public function conteudos()
    {
        return $this->belongsToMany(Conteudo::class);
    }
    /**
     * Relação de tag com tabela aplicativos
     */
    public function aplicativos()
    {
        return $this->belongsToMany(Aplicativo::class);
    }
    /**
     * Seta o atributo name em caixa baixa
     * @param $name cadena de caracteres
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
