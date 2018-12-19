<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
    protected $appends = ['image'];
    protected $casts = [
            'options' => 'array',
    ];
    protected $hidden = ['ts_documento'];

    public function canal()
    {
        return $this->belongsTo('App\Canal', 'canal_id')
                    ->selectRaw("id, name, slug, options->>'color' as color");
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')
                    ->select(['id', 'name']);
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'conteudo_tag', 'conteudo_id', 'tag_id')
                    ->select(['id', 'name']);
    }
    public function componentes()
    {
        return $this->belongsToMany('App\CurricularComponent')
                    ->whereRaw('category_id IS NOT NULL')
                    ->with('categories');
    }
    public function niveis()
    {
        return $this->belongsToMany('App\CurricularComponent')
                    ->whereRaw('nivel_id IS NOT NULL')
                    ->with('niveis');
    }
    public function license()
    {
        return $this->hasOne('App\License', 'id', 'license_id');
    }
    public function getImageAttribute()
    {
        $image = "{$this['id']}.jpg";
        if (Storage::disk('sinopse')->exists($image)) {
            //return Storage::disk('sinopse')
            //            ->url($image);

        } elseif ($this['canal_id'] == 2) {

            return 'emitec';
        } else {
            return '';
        }
    }
}
