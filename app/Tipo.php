<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Canal;
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
        //return Storage::disk('public-path')->url("img/tipo-conteudo/{$slug}.svg");
        return Str::slug($this['name'], '-');
    }
    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?tipos={$this['id']}";
    }
}
