<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Traits\UserCan;

class Tipo extends Model
{
    use UserCan;

    public $timestamps = false;
    protected $fillable = ['name', 'options'];
    protected $appends = ['icon', 'user_can'];
    protected $casts = [
        'options' => 'array',
    ];

    public function getIconAttribute()
    {
        return Storage::disk('public-path')->url("img/tipo-conteudo/{$this['id']}.svg");
    }
}
