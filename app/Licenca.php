<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Licenca extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'site',
    ];

    public function conteudo()
    {
        return $this->belongsTo('App\Conteudo', 'license_id');
    }
}
