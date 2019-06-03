<?php

namespace App;

use App\Conteudo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Aplicativo extends Conteudo
{
    protected $table = 'aplicativos';

    protected $fillable = [
        'name',
        'user_id',
        'canal_id',
        'category_id',
        'description',
        'url',
        'is_featured',
        'options'
    ];
    protected $appends = ['image', 'excerpt', 'url_exibir'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'options' => 'array',
    ];
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('canal_id', 9);
        });
    }
    
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'aplicativo_tag', 'aplicativo_id', 'tag_id')
            ->select(['id', 'name']);
    }
    public function category()
    {
        return $this->hasOne('App\AplicativoCategory', 'id', 'category_id')
            ->select(['id', 'name']);
    }
    
    public function getExcerptAttribute()
    {
        return strip_tags(Str::words($this['description'], 30));
    }
    public function getImageAttribute()
    {
        $image = "{$this['id']}.jpg";
        return Storage::disk('aplicativos-educacionais')
            ->url("imagem-associada/{$image}");
    }
    public function getUrlExibirAttribute()
    {
        $slug = $this->canal()->pluck('slug')->first();

        return "/{$slug}/aplicativo/exibir/" . $this['id'];
    }
}
