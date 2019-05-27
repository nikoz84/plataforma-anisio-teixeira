<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class Conteudo extends Model
{
    protected $id = 'id';
    const IS_SITE = 'false';
    const IS_APPROVED = 'false';
    const IS_FEATURED = 'false';
    const INIT_COUNT = 0;

    protected $fillable = [
        'approving_user_id',
        'canal_id',
        'license_id',
        'category_id',
        'title',
        'description',
        'source',
        'authors',
        'is_site',
        'is_featured',
        'is_approved',
        'options',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $appends = ['image', 'excerpt'];
    protected $casts = [
        'options' => 'array',
    ];
    protected $hidden = ['ts_documento'];

    public function canal()
    {
        return $this->belongsTo(\App\Canal::class, 'canal_id')
            ->selectRaw("id, name, slug, options->>'color' as color");
    }
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id')
            ->select(['id', 'name']);
    }
    public function tags()
    {
        return $this->belongsToMany(\App\Tag::class, 'conteudo_tag', 'conteudo_id', 'tag_id')
            ->select(['id', 'name']);
    }

    public function componentes()
    {
        return $this->belongsToMany(\App\CurricularComponent::class)
            ->whereRaw('category_id IS NOT NULL')
            ->with('categories');
    }
    public function niveis()
    {
        return $this->belongsToMany(\App\CurricularComponent::class)
            ->whereRaw('nivel_id IS NOT NULL')
            ->with('niveis');
    }
    public function license()
    {
        return $this->hasOne(\App\License::class, 'id', 'license_id');
    }
    public function getExcerptAttribute()
    {
        return strip_tags(Str::words($this['description'], 30));
    }
    public function getImageAttribute()
    {
        $image = "{$this['id']}.jpg";
        $id = $this['id'];
        $canal = $this['canal_id'];

        if (Storage::disk('sinopse')->exists($image)) {
            //return Storage::disk('sinopse')
            //            ->url($image);
        } elseif ($canal == 2) {
            $conteudo = $this->whereId($id)->get();
            //$cmp_array = (object)$cmp_array->toArray();
            //dd($conteudo);
            //$nivel = DB::table('curricular_components')->where('id', 5)->whereIn('id', $componentes)->toSql();
            //imagem-associada/img-emitec_disciplina29.png
            //dd($nivel);
            //dd($nivel);
            //die();
            return "emitec";
        } else {
            return '';
        }
    }
}
