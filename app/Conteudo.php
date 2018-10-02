<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conteudo extends Model
{
    protected $id = 'id';
    protected $fillable = [
        'title', 
        'description', 
        'is_featured', 
        'is_approved', 
        'options',
        'created_at'];
    
    public function getCanal()
    {
        return $this->belongsTo('App\Canal');
    }
}
