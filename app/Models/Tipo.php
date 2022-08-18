<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Canal;
use App\Helpers\ReplaceStr;
use App\Traits\UserCan;
use App\Traits\WithoutAppends;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Tipo extends Model
{
    use UserCan, WithoutAppends;

    public $timestamps = false;
    protected $fillable = ['name', 'options'];
    protected $appends = ['icon', 'user_can', 'search_url'];
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Seleciona o icone do atributo
     *
     * @return void
     */

    public function icon(): Attribute{
       return new Attribute(
           get: fn () =>"/img/tipo-conteudo/" . Str::slug($this->name, '-') . ".svg"
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

    public function searchUrl(): Attribute{
        $get = function (){
            $canal = Canal::find(6);
            return "/{$canal->slug}/listar?tipos={$this['id']}";
        };

        return new Attribute(
            get: $get
        );
    }


}
