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
        'created_at',
        'updated_at'
    ];
    protected $hiden = ['ts_documento','deleted_at'];

    public function canal()
    {
        return $this->belongsTo('App\Canal');
    }
}
