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

    protected $casts = [
            'options' => 'array',
    ];
    protected $hidden = ['ts_documento'];

    public function canal()
    {
        return $this->belongsTo('App\Canal', 'canal_id');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
    
}
