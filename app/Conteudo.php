<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\FileSystemLogic;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use App\Canal;
use App\User;
use App\Tag;
use Auth;

class Conteudo extends Model
{
    use FileSystemLogic, SoftDeletes;

    protected $id = 'id';
    const IS_SITE = 'false';
    const IS_APPROVED = 'false';
    const IS_FEATURED = 'false';
    const INIT_COUNT = 0;

    protected $fillable = [
        'approving_user_id',
        'user_id',
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
    protected $appends = ['image', 'excerpt', 'url_exibir', 'tipo', 'permission', 'arquivos'];
    protected $casts = ['options' => 'array',];
    protected $hidden = ['ts_documento'];
    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function canal()
    {
        Canal::$without_appends = true;

        return $this->belongsTo(Canal::class, 'canal_id')
            ->select(['id', 'name', 'slug', 'options->color as color']);
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->select(['id', 'name']);
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function tags()
    {
        return $this->belongsToMany(\App\Tag::class, 'conteudo_tag', 'conteudo_id', 'tag_id')
            ->select(['id', 'name']);
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function componentes()
    {
        return $this->belongsToMany(\App\CurricularComponent::class)
            ->whereRaw('category_id IS NOT NULL')
            ->with('categories');
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function niveis()
    {
        return $this->belongsToMany(\App\CurricularComponent::class)
            ->whereRaw('nivel_id IS NOT NULL')
            ->with('niveis');
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function license()
    {
        return $this->hasOne(\App\License::class, 'id', 'license_id');
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getExcerptAttribute()
    {
        return strip_tags(Str::words($this['description'], 30));
    }
    public function getMetaDados($pasta)
    {
        $filesystem = new \Illuminate\Filesystem\Filesystem;
        $id = $this['id'];
        $path = \Illuminate\Support\Facades\Storage::disk('conteudos-digitais')->path($pasta) . "/{$id}.*";
        $files = $filesystem->glob($path);
        $arr = [];
        foreach ($files as $file) {
            $name = $filesystem->name($file) . "." . $filesystem->extension($file);
            $arr = [
                'mime_type' => $filesystem->mimeType($file),
                'extension' => $filesystem->extension($file),
                'size'      => $filesystem->size($file),
                'name'      => $name,
                'url'       => \Illuminate\Support\Facades\Storage::disk('conteudos-digitais')->url($pasta) . "/{$name}"
            ];
        }
        return $arr;
    }
    public function getArquivosAttribute()
    {
        $arrAr = [
            'download'      => $this->getMetaDados('download'),
            'visualizacao'  => $this->getMetaDados('visualizacao'),
            'guia'          => $this->getMetaDados('guias-pedagogicos'),
        ];
        return $arrAr;
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getImageAttribute()
    {
        $id = $this['id'];
        $canal = $this['canal_id'];
        $tipo = $this['options']['tipo'];
        $components = $this['options']['componentes'];

        if ($canal == 2) {
            return $this::getEmitecImage($components);
        } else {
            return $this::getImageFromTipo($tipo, $id);
        }
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getPermissionAttribute()
    {
        if (Gate::any(['update', 'delete', 'super-admin'], $this)) {
            return true;
        }
    }
    public function getUrlExibirAttribute()
    {
        $slug = $this->canal()->pluck('slug')->first();
        return "/{$slug}/conteudo/exibir/" . $this['id'];
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getTipoAttribute()
    {
        return DB::table('tipos')->where('id', $this['options']['tipo'])->get(["id", "name"])->first();
    }

    public function scopeSearch($query, $search)
    {
        
        if (!$search) {
            return $query;
        }

        return $query->whereRaw('ts_documento @@ plainto_tsquery(\'simple\', lower(unaccent(?)))', [$search])
            ->orderByRaw('ts_rank(ts_documento, plainto_tsquery(\'simple\', lower(unaccent(?)))) DESC', [$search]);
    }

    public function scopeSearchTag($query, $id)
    {
        if (!$id) {
            return $query;
        }
        Tag::where('id', $id)->increment('searched', 1);

        return $query->whereHas("tags", function ($q) use ($id) {
            return $q->where('id', '=', $id);
        });
    }
}
