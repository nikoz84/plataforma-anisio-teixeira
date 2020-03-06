<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\FileSystemLogic;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Canal;
use App\User;
use App\Tag;
use App\CurricularComponent;
use App\License;
use App\Category;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use App\Helpers\TransformDate;
use App\Traits\UserCan;

class Conteudo extends Model
{
    use FileSystemLogic, SoftDeletes, UserCan;

    protected $id = 'id';
    const IS_SITE = 'false';
    const IS_APPROVED = 'false';
    const IS_FEATURED = 'false';
    const INIT_COUNT = 0;
    public static $TYPE_SEARCH = 'simple';

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
    protected $appends = ['image', 'excerpt', 'url_exibir', 'user_can', 'arquivos', 'formated_date'];
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
     * Conteúdo tipo
     *
     * @return void
     */
    public function tipo()
    {
        Tipo::$without_appends = true;

        return $this->hasOne(Tipo::class, 'id', 'tipo_id')->select(['id', 'name']);
    }
    /**
     * Seleciona as Tags relacionadas
     *
     * @return void
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'conteudo_tag', 'conteudo_id', 'tag_id')
            ->select(['id', 'name'])->orderBy('name');
    }
    /**
     * Seleciona os componentes curriculares
     *
     * @return void
     */
    public function componentes()
    {
        return $this->belongsToMany(
            CurricularComponent::class,
            'conteudo_curricular_component',
            'conteudo_id',
            'curricular_component_id'
        )->orderBy('name');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
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
        return strip_tags(Str::words($this->description, 30));
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

        $path = Storage::disk('conteudos-digitais')->path($pasta) . "/{$this['id']}.*";
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
     * Seleciona os Arquivos de download, visualizaçao e guias pedagógicas
     *
     * @return void
     */
    public function getArquivosAttribute()
    {
        $arrAr = [
            'download'      => (object) $this->getMetaDados('download'),
            'visualizacao'  => (object) $this->getMetaDados('visualizacao'),
            'guia'          => (object) $this->getMetaDados('guias-pedagogicos'),
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
        $tipo = $this['tipo_id'];
        $components = $this->componentes();

        if ($canal == 2) {
            return $this::getEmitecImage($components);
        } else {
            return $this::getImageFromTipo($tipo, $id);
        }
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
     * Filtro para full text search
     *
     * @param [type] $query
     * @param [type] $search
     * @return void
     */
    public function scopeSearch($query, $search, $por)
    {

        if (!$search) {
            return $query;
        }

        $type = ($por == 'tag') ? "simple" : "portuguese";
        return $query->whereRaw('ts_documento @@ plainto_tsquery(?, lower(unaccent(?)))', [$type, $search])
            ->orderByRaw('ts_rank(ts_documento, plainto_tsquery(?, lower(unaccent(?)))) DESC', [$type, $search]);
    }
    /**
     * Filtro de busca por tags e incrementa das veces buscada
     *
     * @param [type] $query
     * @param [type] $id
     * @return void
     */
    public function scopeSearchTag($query, $tag_id)
    {
        if (!$tag_id) {
            return $query;
        }
        Tag::where('id', $tag_id)->increment('searched', 1);

        return $query->whereHas("tags", function ($q) use ($tag_id) {
            return $q->where('id', '=', $tag_id);
        });
    }
    public function scopeSearchByComponent($query, $componentes)
    {
        if (!$componentes) {
            return $query;
        }

        return $query->whereHas("componentes", function ($q) use ($componentes) {

            return $q->whereIn('id', explode(',', $componentes));
        });
    }
    public static function tsDocumentoSave($id)
    {
        if (!$id) {
            return;
        }

        $conteudo = parent::find($id);

        $fullTextSearch = DB::table('conteudos as c')
            ->selectRaw("setweight( to_tsvector( 'simple',
                    (SELECT string_agg(lower(COALESCE(unaccent(t.name),'')), ' ' )
                    FROM conteudo_tag AS ct
                    INNER JOIN tags t ON t.id = ct.tag_id
                    WHERE ct.conteudo_id = c.id)), 'A') ||
            setweight( to_tsvector( 'simple', lower( COALESCE( unaccent(c.title), '') ) ), 'A' ) ||
            setweight( to_tsvector( 'portuguese',
                                    lower( COALESCE( unaccent(concat(c.source, ' ', c.authors)), '') ) ), 'C' ) ||
            setweight( to_tsvector( 'portuguese', unaccent(lower(
               regexp_replace(
               regexp_replace(
               regexp_replace( c.description
               , E'<.*?>', '', 'g')
               , E'&nbsp;', ' ', 'g')
               , E'[\\n\\r]+', ' ', 'g')
           ))),'D') AS ts_documento")
            ->where('id', '=', $id)
            ->get()
            ->first();


        dd($conteudo);

        $conteudo->save([
            'ts_documento' => $fullTextSearch->ts_documento
        ]);
    }
}
