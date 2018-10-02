<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    protected $table = 'canais';
    protected $id = 'id';
    /**
     * $fillable São todos os atributos que podem ser asignables
     */
    protected $fillable = [
        'name', 
        'description', 
        'is_active', 
        'slug', 
        'options'
    ];
    
    public function conteudos()
    {
        return $this->hasMany('App\Conteudo');
    }

}
