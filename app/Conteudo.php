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
use App\Helpers\TransformDate;
use App\Traits\UserCan;
use Illuminate\Support\Facades\Auth;

class Conteudo extends Model
{
    use FileSystemLogic, SoftDeletes, UserCan;

    const IS_SITE = false;
    const IS_APPROVED = false;
    const INIT_COUNT = 0;
    public static $TYPE_SEARCH = 'simple';

    protected $fillable = [
        'approving_user_id',
        'user_id',
        'canal_id',
        'tipo_id',
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

    protected $appends = ['image', 'excerpt', 'short_title', 'url_exibir', 'user_can', 'arquivos', 'formated_date', 'title_slug'];
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
        //Tipo::$without_appends = true;

        return $this->hasOne(Tipo::class, 'id', 'tipo_id')
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
    /**
     * Seleciona a categoria do conteúdo
     *
     * @return void
     */
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
     * Muta o valor do usuário que aprova o conteúdo
     * @param [type] $user
     * @return void
     */
    public function setApprovingUserIdAttribute($user)
    {
        $id = null;
        
        if ($user->is('admin') || $user->is('super-admin') || $user->is('coordenador')) {
            $id = $user->id;
        }

        $this->attributes['approving_user_id'] = $id;
    }

    /**
     * Muta o valor si o conteúdo é aprovado
     *
     * @param [type] $value
     * @return void
     */
    public function setIsApprovedAttribute($value)
    {
        $approved = self::IS_APPROVED;

        if ($this->getAttribute('approving_user_id') !== null) {
            $approved = (bool) $value;
        }

        $this->attributes['is_approved'] = $approved;
    }
    /**
     * Muta o valor si o conteúdo é site
     *
     * @param [type] $value
     * @return void
     */
    public function setIsSiteAttribute($value)
    {
        $is_site = self::IS_SITE;

        if ($this['options']['site'] && $this->getAttribute('tipo_id') === 8) {
            $is_site = $value;
        }

        $this->attributes['is_site'] =  (bool) $is_site;
    }
    /**
     * Muta o valor si o conteúdo é marcado como destaque
     *
     * @param [type] $value
     * @return void
     */
    public function setIsFeaturedAttribute($value)
    {
        $this->attributes['is_featured'] = (bool) $value;
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
     * Adiciona novo atributo ao objeto que limita o tamanho da descrição
     *
     * @return void
     */
    public function getShortTitleAttribute()
    {
        return Str::words($this->title, 5);
    }
    /**
     * Converte o título para slug ou url amigável
     */
    public function getTitleSlugAttribute()
    {
        return Str::slug(Str::words($this->title, 50), '-');
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
     * desde o Trait App\Traits\File
     *
     * @return array
     */
    public function getArquivosAttribute()
    {
        return [
            'download'      => $this->getMetaDados('download', $this['id']),
            'visualizacao'  => $this->getMetaDados('visualizacao', $this['id']),
            'guias-pedagogicos'          => $this->getMetaDados('guias-pedagogicos', $this['id']),
        ];
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
     * @param $query  Eloquent\Query instance
     * @param $search termo de busca
     * @param $por    define se busca é por tag ou título
     *
     * @return Eloquent\Query instance
     */
    public function scopeFullTextSearch($query, $search, $por)
    {

        if (!$search) {
            return $query;
        }

        $type = ($por == 'tag') ? "simple" : "portuguese";
        return $query->whereRaw('ts_documento @@ plainto_tsquery(?, lower(unaccent(?)))', [$type, $search])
            ->orderByRaw('ts_rank(ts_documento, plainto_tsquery(?, lower(unaccent(?)))) DESC', [$type, $search]);
    }
    /**
     * Filtro de busca por tags e incrementa as veces buscada
     *
     * @param $query Eloquent\Query
     * @param $id    id da palavra chave
     * @return App\Conteudo
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
    /**
     * Buscar por componente curricular
     *
     * @param $query       Eloquent\Query
     * @param $componentes ids dos componentes a buscar
     *
     * @return App\Conteudo
     */
    public function scopeSearchByComponent($query, $componentes)
    {
        if (!$componentes) {
            return $query;
        }

        return $query->whereHas("componentes", function ($q) use ($componentes) {

            return $q->whereIn('id', explode(',', $componentes));
        });
    }
    /**
     * Buscar por colunas especificas
     *
     * @param $query    Eloquent\Query
     * @param $column   coluna a buscar
     * @param $data     ids ou id de busca
     * @param $multiple busca com where in ou where
     *
     * @return App\Conteudo
     */
    public function scopeSearchByColumn($query, $column, $data, $multiple = false)
    {
        if (!$data) {
            return $query;
        }

        if ($multiple) {
            return $query->whereIn($column, explode(',', $data));
        }

        return $query->where($column, $data);
    }
    /**
     * Busca por canal
     *
     * @param $query    Eloquent\Query
     * @param $canal_id id a procurar canal 6 são a suma de todos os canais
     *
     * @return App\Conteudo
     */
    public function scopeSearchByCanal($query, $canal_id)
    {
        if (!$canal_id || $canal_id == 6) {
            return $query;
        }

        return $query->where('canal_id', $canal_id);
    }
    
    public function scopeSortBy($query, $by)
    {
        if (!$by) {
            return $query;
        }
        $order_by = null;
        $sort = 'DESC';
        switch ($by) {
            case 'downloads':
                $order_by = 'qt_downloads';
                break;
            case 'acessos':
                $order_by = 'qt_access';
                break;
            case 'titulo':
                $order_by = 'title';
                $sort = 'ASC';
                break;
            default:
                $order_by = 'created_at';
                break;
        }
        return $query->orderBy($order_by, $sort);
    }
    public static function tsDocumentoSave($id)
    {
        if (!$id) {
            return;
        }

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

        DB::update('update conteudos set ts_documento = ? where id = ?', [$fullTextSearch->ts_documento, $id]);
    }

    public function scopeRelacionados($query, $id)
    {
        if (!$id) {
            return $query;
        }
        $tags_query = function ($q) {
            return $q->limit(2);
        };
        $conteudo = parent::with(['tags'=> $tags_query])->find($id);
        $tags = $conteudo->tags->implode('name', ', ');
        
        return parent::whereRaw(
            "conteudos.ts_documento @@ plainto_tsquery('portuguese', lower(unaccent('{$tags}')))"
        )->orWhereRaw(
            "conteudos.ts_documento @@ plainto_tsquery('simple', lower(unaccent('{$tags}')))"
        )->where('id', '!=', $id);
    }
}
