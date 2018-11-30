<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aplicativo extends Model
{
    protected $id = 'id';
    protected $fillable = [
        'name',
        'description',
        'is_featured',
        'options'
        ];
    protected $dates = [
            'created_at',
            'updated_at',
            'deleted_at'
    ];
    protected $casts = [
        'options' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')
                    ->select(['id','name']);
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag')
                    ->select(['id', 'name']);
    }
    public function category()
    {
        return $this->hasOne('App\AplicativoCategory', 'id', 'category_id')
                    ->select(['id', 'name']);
    }
    public function canal()
    {
        return $this->hasOne('App\Canal', 'id', 'canal_id')
                    ->selectRaw("id, name, options->>'color' as color ");
    }
    
}
