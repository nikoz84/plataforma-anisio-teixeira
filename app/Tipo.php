<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class Tipo extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'options'];
    protected $appends = ['icon'];
    protected $casts = [
        'options' => 'array',
    ];

    public function getIconAttribute()
    {
        return Storage::disk('public-path')->url("img/tipo-conteudo/{$this['id']}.svg");
    }
}
