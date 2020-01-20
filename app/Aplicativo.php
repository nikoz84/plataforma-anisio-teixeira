<?php

namespace App;

use App\Conteudo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\TransformDate;

class Aplicativo extends Conteudo
{
    use SoftDeletes;

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
    protected $appends = [
        'image',
        'excerpt',
        'url_exibir',
        'formated_date'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'options' => 'array',
    ];
    /**
     * Clase que extende de conteúdo
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('canal_id', 9);
        });
    }
    /**
     * Conjunto de tags do aplicativo
     *
     * @return void
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'aplicativo_tag', 'aplicativo_id', 'tag_id')
            ->select(['id', 'name']);
    }
    /**
     * Conjunto de categorias do aplicativo
     *
     * @return void
     */
    public function category()
    {
        return $this->hasOne('App\AplicativoCategory', 'id', 'category_id')
            ->select(['id', 'name']);
    }
    /**
     * Descrição abreviada
     *
     * @return void
     */
    public function getExcerptAttribute()
    {
        return strip_tags(Str::words($this['description'], 30));
    }
    /**
     * Imagem de destaque do aplicativo
     *
     * @return void
     */
    public function getImageAttribute()
    {
        $image = "{$this['id']}.jpg";
        return Storage::disk('aplicativos-educacionais')
            ->url("imagem-associada/{$image}");
    }
    /**
     * Cria url exibir
     *
     * @return void
     */
    public function getUrlExibirAttribute()
    {
        $slug = $this->canal()->pluck('slug')->first();

        return "/{$slug}/aplicativo/exibir/" . $this['id'];
    }
    /**
     * Seleciona e tranforma created-at ao formato (06 setembro de 2019 ás 17:37)
     *
     * @return void
     */
    public function getFormatedDateAttribute()
    {
        return TransformDate::format($this['created_at']);
    }
    /**
     * Cria aplicativo no banco de dados
     *
     * @param object $request
     * @return App\Aplicativo
     */
    /*
    public static function create($request)
    {
        $aplicativo = new \App\Aplicativo();

        $aplicativo->user_id = Auth::user()->id;
        $aplicativo->category_id = $request->category_id;
        $aplicativo->canal_id = 9;
        $aplicativo->name = $request->name;
        $aplicativo->url = $request->url;
        $aplicativo->description = $request->description;
        $aplicativo->is_featured = $request->is_featured;

        $aplicativo->options = json_decode($request->options, true);
        $aplicativo->tags->attach($request->tags);

        $aplicativo->save();

        return $aplicativo;
    }
    */
}
