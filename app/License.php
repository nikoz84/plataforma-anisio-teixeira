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
        'name', 'description', 'site', 'parent_id'
    ];

    public function conteudo()
    {
        return $this->belongsTo('App\Conteudo', 'license_id');
    }
    
    public function parent()
    {
        return $this->hasMany('App\License', 'parent_id', 'id');
    }
}
