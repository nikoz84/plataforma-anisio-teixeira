<?php

namespace App\Models;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;use UserCan;

    public const INIT_SEARCHED = 0;

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
     *
     * @param $name cadena de caracteres
     */
    public function name(): Attribute
    {
        return new Attribute(
            set: fn ($value) => strtolower($value)
        );
    }
}
