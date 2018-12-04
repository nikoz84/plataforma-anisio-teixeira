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
        'is_site',
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
        return $this->belongsTo('App\Canal', 'canal_id')
                    ->selectRaw("id, name, options->>'color' as color ");
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')
                    ->select(['id', 'name']);
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag')
                    ->select(['id', 'name']);
    }
    public function componentes()
    {
        return $this->belongsToMany('App\CurricularComponent')->with(['categories','niveis']);
    }
    public function license()
    {
        return $this->hasOne('App\License', 'id', 'license_id');
    }
}
