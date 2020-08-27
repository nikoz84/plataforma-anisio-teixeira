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
     * Função conteúdo Pertence a Muitos
     * Variavel protegida com os campos a ser adcionado e array associativo
     * @param \App\Role $role
     * @return \App\Model\ApiResponser retorna json
     */
    public function conteudos()
    {
        return $this->belongsToMany(Conteudo::class);
    }
    /**
     * Função aplicativos Pertence a Muitos
     * Variavel protegida com os campos a ser adcionado e array associativo
     * @param \App\Role $role
     * @return \App\Model\ApiResponser retorna json
     */
    public function aplicativos()
    {
        return $this->belongsToMany(Aplicativo::class);
    }
    /**
     * Função seleciona o nome do Atributo Pertence a Muitos
     * Variavel protegida com os campos a ser adcionado e array associativo
     * @param \App\Role $role
     * @return \App\Model\ApiResponser retorna json
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
