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
        'options'];
    protected $dates = [
            'created_at',
            'updated_at',
            'deleted_at'
    ];    
    protected $casts = [
            'options' => 'array',
    ];
    protected $hidden = ['ts_documento'];

    public function canal()
    {
        return $this->belongsTo('App\Canal', 'canal_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
    public function licenca()
    {
        return $this->hasOne('App\Licenca');
    }
    
}
