<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Aplicativo extends Model
{
    protected $id = 'id';
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
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')
            ->select(['id', 'name']);
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
    public function canal()
    {
        return $this->belongsTo('App\Canal', 'canal_id')
            ->selectRaw("id, name, slug, options->>'color' as color ");
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
