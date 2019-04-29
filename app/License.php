<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'site', 'parent_id',
    ];

    public function conteudo()
    {
        return $this->belongsTo(\App\Conteudo::class, 'license_id');
    }

    public function childs()
    {
        return $this->hasMany(\App\License::class, 'parent_id', 'id');
    }
}
