<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Canal;
use App\Traits\UserCan;

class Tipo extends Model
{
    use UserCan;

    public $timestamps = false;
    protected $fillable = ['name', 'options'];
    protected $appends = ['icon', 'user_can', 'search_url'];
    protected $casts = [
        'options' => 'array',
    ];

    public function getIconAttribute()
    {
        return Storage::disk('public-path')->url("img/tipo-conteudo/{$this['id']}.svg");
    }
    public function getSearchUrlAttribute()
    {
        $canal = Canal::find(6);
        return "/{$canal->slug}/listar?tipos={$this['id']}";
    }
}
