<?php

namespace App\Models;

use App\Traits\UserCan;
use App\Traits\WithoutAppends;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tipo extends Model
{
    use UserCan;
    use WithoutAppends;

    public $timestamps = false;

    protected $fillable = ['name', 'options'];

    protected $appends = ['icon', 'user_can', 'search_url'];


    public function options(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    /**
     * Seleciona o icone do atributo
     *
     * @return void
     */
    public function icon(): Attribute
    {
        return new Attribute(
            get: fn () => '/img/tipo-conteudo/' . Str::slug($this->name, '-') . '.svg'
        );
    }

    /**
     * Seleciona a busca do atributo por meio da url
     *
     * @return void
     */
    //public function getSearchUrlAttribute()
    //  {
    //   $canal = Canal::find(6);
    //return "/{$canal->slug}/listar?tipos={$this['id']}";
    //    }

    public function searchUrl(): Attribute
    {
        $get = function () {
            $canal = Canal::find(6);

            return "/{$canal->slug}/listar?tipos={$this['id']}";
        };

        return new Attribute(
            get: $get
        );
    }
}