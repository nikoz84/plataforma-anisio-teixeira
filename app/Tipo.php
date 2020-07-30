<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Canal;
use App\Helpers\ReplaceStr;
use App\Traits\UserCan;
use App\Traits\WithoutAppends;
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

    public function getIconAttribute()
    {
        if ($this->name) {
            //$iconeNome = ReplaceStr::replace($this->name);
            //return Storage::disk('public-path')->url("img/tipo-conteudo/".strtolower($iconeNome).".svg");
            return Str::slug($this->name, '-'); //strtolower($iconeNome);
        }
        return "";
    }
    

    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?tipos={$this['id']}";
    }
}
