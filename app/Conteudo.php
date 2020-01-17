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
use App\CurricularComponent;
use App\License;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
     * Seleciona o canal do conteúdo sem os campos adicionais
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
     * Seleciona usuário publicador
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->select(['id', 'name']);
    }
    /**
     * Seleciona as Tags relacionadas
     *
     * @return void
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'conteudo_tag', 'conteudo_id', 'tag_id')
            ->select(['id', 'name']);
    }
    /**
     * Seleciona os componentes curriculares
     *
     * @return void
     */
    public function componentes()
    {
        return $this->belongsToMany(CurricularComponent::class)
            ->whereRaw('category_id IS NOT NULL')
            ->with('categories');
    }
    /**
     * Seleciona niveis de ensino
     *
     * @return void
     */
    public function niveis()
    {
        return $this->belongsToMany(CurricularComponent::class)
            ->whereRaw('nivel_id IS NOT NULL')
            ->with('niveis');
    }
    /**
     * Seleciona a licença relacionada
     *
     * @return void
     */
    public function license()
    {
        return $this->hasOne(License::class, 'id', 'license_id');
    }
    /**
     * Adiciona novo atributo ao objeto que limita o tamanho da descrição
     *
     * @return void
     */
    public function getExcerptAttribute()
    {
        return strip_tags(Str::words($this['description'], 30));
    }
    /**
     * Seleciona todos os metadados dos arquivos do conteúdo
     *
     * @param [type] $pasta
     * @return void
     */
    public function getMetaDados($pasta)
    {
        $filesystem = new Filesystem;
        $id = $this['id'];
        $path = Storage::disk('conteudos-digitais')->path($pasta) . "/{$id}.*";
        $files = $filesystem->glob($path);
        $arr = [];
        foreach ($files as $file) {
            $name = $filesystem->name($file) . "." . $filesystem->extension($file);
            $arr = [
                'mime_type' => $filesystem->mimeType($file),
                'extension' => $filesystem->extension($file),
                'size'      => $filesystem->size($file),
                'name'      => $name,
                'url'       => Storage::disk('conteudos-digitais')->url($pasta) . "/{$name}"
            ];
        }
        return $arr;
    }
    public function getCreatedAtAttribute($value)
    {
        $locale = env('APP_LOCALE');
        $timezone = env('APP_TIMEZONE');
        $carbon = new Carbon($value, $timezone, $locale);
        //"10 de dezembro de 2019 às 19:44";
        return "{$carbon->day} de {$carbon->month} de {$carbon->year} às {$carbon->hour}:{$carbon->minute}";
    }
    /**
     * Seleciona os Arquivos de download, visualizaçao e guias pedagógicas
     *
     * @return void
     */
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
     * Adiciona atributo imagem associada ao objeto
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
     * Permissões do usuário
     *
     * @return void
     */
    public function getPermissionAttribute()
    {
        if (Gate::any(['update', 'delete', 'super-admin'], $this)) {
            return true;
        }

        return false;
    }
    /**
     * Adiciona atributo url_exibir
     *
     * @return void
     */
    public function getUrlExibirAttribute()
    {
        $slug = $this->canal()->pluck('slug')->first();
        return "/{$slug}/conteudo/exibir/" . $this['id'];
    }
    /**
     * Adiciona o atributo tipo de conteúdo ao objeto
     *
     * @return void
     */
    public function getTipoAttribute()
    {
        return DB::table('tipos')->where('id', $this['options']['tipo'])->get(["id", "name"])->first();
    }
    /**
     * Filtro para full text search
     *
     * @param [type] $query
     * @param [type] $search
     * @return void
     */
    public function scopeSearch($query, $search)
    {

        if (!$search) {
            return $query;
        }

        return $query->whereRaw('ts_documento @@ plainto_tsquery(\'simple\', lower(unaccent(?)))', [$search])
            ->orderByRaw('ts_rank(ts_documento, plainto_tsquery(\'simple\', lower(unaccent(?)))) DESC', [$search]);
    }
    /**
     * Filtro de busca por tags e incrementa das veces buscada
     *
     * @param [type] $query
     * @param [type] $id
     * @return void
     */
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
