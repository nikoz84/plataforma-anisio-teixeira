<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    protected $table = 'canais';
    protected $id = 'id';
    protected $fillable = [
        'name', 
        'description', 
        'is_active', 
        'slug', 
        'options',
        'created_at'
    ];
    
    public function conteudos()
    {
        return $this->hasMany('App\Conteudo');
    }

}
