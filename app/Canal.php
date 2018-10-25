<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    protected $hidden = ['token'];
    protected $dates = ['deleted_at'];
    
    public function conteudos()
    {
        return $this->hasMany('App\Conteudo');
    }

}
