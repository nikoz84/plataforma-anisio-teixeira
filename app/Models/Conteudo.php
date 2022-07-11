<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\FileSystemLogic;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Canal;
use App\Models\User;
use App\Models\Tag;
use App\Models\Tipo;
use App\Models\CurricularComponent;
use App\Models\License;
use App\Models\Category;
use App\Models\NivelEnsino;
use App\Helpers\TransformDate;
use App\Traits\UserCan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Conteudo extends Model
{
    use FileSystemLogic, SoftDeletes, UserCan;

    const IS_SITE = 'false';
    const IS_APPROVED = 'false';
    const INIT_COUNT = 0;
    public static $TYPE_SEARCH = 'simple';
    /**Tabela com campos definidos */
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
    /**
     * Tabela com campos definidos
     */
    protected $appends = ['image', 'excerpt', 'short_title', 'url_exibir', 'user_can', 'arquivos', 'formated_date', 'title_slug', 'download', 'guiaPedagogico'];
    /**
     * Tabela com campos definidos
     */
    protected $casts = ['options' => 'array',];
    /**
     * Tabela com campos definidos
     */
    protected $hidden = ['ts_documento'];

    /**
     * Seleciona o canal do conteúdo sem os campos adicionais
     *
     * @return Canal instância belongstTo pertence a Canal
     */
    public function canal()
    {
        Canal::$without_appends = true;

        return $this->belongsTo(Canal::class, 'canal_id')
            ->select(['id', 'name', 'slug', 'options->color as color']);
    }
    /**
     * Seleciona usuário publicador
     * @return User instâcia belongsTo pertence a user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->select(['id', 'name']);
    }
    /**
     * Conteúdo tipo
     * @return Tipo instância HasOne Tem um
     */
    public function tipo()
    {
        return $this->hasOne(Tipo::class, 'id', 'tipo_id')
            ->select(['id', 'name']);
    }
    /**
     * Seleciona as Tags relacionadas
     * @return Tag instância Pertence a Muitos belongs To Many
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'conteudo_tag', 'conteudo_id', 'tag_id')
            ->select(['id', 'name'])->orderBy('name');
    }
    /**
     * Seleciona os componentes curriculares
     * @return CurricularComponent instância Pertence a Muitos belongs To Many
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
     * @return Category instância Pertence à belongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Seleciona niveis de ensino
     * @return NivelEnsino instância Pertence a muitos belongsToMany 
     */
    public function niveis()
    {
        return $this->belongsToMany(
            NivelEnsino::class,
            'curricular_components',
            'id',
            'nivel_id'
        );
    }

    /**
     * Seleciona a licença relacionada
     * @return License intância Há um has one 
     */
    public function license()
    {
        return $this->hasOne(License::class, 'id', 'license_id');
    }

    /**
     * Seta o atributo aprovado (isApproved)
     * @param boolean $value Valor de tipo booleano true false
     * @return void
     */
    public function isApproved(): Attribute
    {
        $set = function () {
            $user_can = $this->userCan();
            $is_approved = false;
            if ($user_can['create'] || $user_can['update']) {
                $is_approved = true;
            }
            return $is_approved;
        };

        return new Attribute(
            set: $set 
        );
    }
    /**
     * Seta o atributo usuário que aprova um conteúdo (approvedUserId)
     * @param integer $value Identificador único do usuário
     * @return void
     */
    public function approvingUserId(): Attribute
    {
        return new Attribute(
            set: fn () => Auth::user()->id ? Auth::user()->id : null
        );
    }

    /**
     * Adiciona novo atributo ao objeto que limita o tamanho da descrição
     * @return string cadeia de caracteres
     */
    public function getExcerptAttribute()
    {
        return strip_tags(Str::words($this->description, 30));
    }
    /**
     * Adiciona novo atributo ao objeto que limita o tamanho do título
     * @return string cadeia de caracteres
     */
    public function getShortTitleAttribute()
    {
        return Str::words($this->title, 8);
    }
    /**
     * Converte o título para slug ou url amigável
     */
    public function getTitleSlugAttribute()
    {
        return Str::slug(Str::words($this->title, 30), '-');
    }
    /**
     * Seleciona e tranforma created-at ao formato (06 setembro de 2019 ás 17:37)
     * @return void
     */
    public function getFormatedDateAttribute()
    {
        return TransformDate::format($this['created_at']);
    }
    /**
     * Seleciona os Arquivos de download, visualizaçao e guias pedagógicas
     * @return array
     */
    public function getArquivosAttribute()
    {
        return [
            'download'           => $this->getMetaDados('download', $this['id']),
            'visualizacao'       => $this->getMetaDados('visualizacao', $this['id']),
            'guias-pedagogicos'  => $this->getMetaDados('guias-pedagogicos', $this['id']),
        ];
    }

    /**
     * Adiciona atributo imagem associada ao objeto
     * @return string url da imagem
     */
    public function getImageAttribute()
    {
        $id = $this['id'];
        $image = $this::getImageFromConteudo($id);
        if (!$image) {
            $image = $this->getCategoryImage($this->category_id);
        }
        if (!$image) {
            $image = $this->getImageFromTipo($this->tipo, $this->id);
        }
        return $image;
    }


    /**
     * Recupera referencia ao arquivo de download
     * @return string referência ao arquivo de download
     */
    public function getDownloadAttribute()
    {
        return $this->downloadFileConteudo($this->id);
    }

    /**
     * Adiciona atributo Guia Pedagogico ao objeto
     * @return string referência ao arquivo de guia pedagogico
     */
    public function getGuiaPedagogicoAttribute()
    {
        return $this->guiaPedagogicoFileConteudo($this->id);
    }

    /**
     * Adiciona atributo url_exibir
     * @return string
     */
    public function getUrlExibirAttribute()
    {
        $slug = $this->canal()->pluck('slug')->first();
        return "/{$slug}/conteudo/exibir/" . $this['id'];
    }
    /**
     * Filtro para conteúdos Aprovados
     * @param Builder $query instância do query builder
     * @param boolean $is_approved Verdadeiro ou Falso se conteúdo é aprovado
     * @return void
     */
    public function scopeApproved(Builder $query, $is_approved)
    {
        if (!$is_approved) {
            return $query;
        }
        return $query->where('is_approved', $is_approved);
    }
    /**
     * Filtro para full text search
     * @param Builder $query instância do query builder
     * @param string $search termo de busca
     * @param string $por define se busca é por tag ou título
     * @return void
     */
    public function scopeFullTextSearch(Builder $query, $search, $por)
    {
        if (!$search) {
            return $query;
        }
        $type = ($por == 'tag') ? "simple" : "portuguese";
        return $query->whereRaw("ts_documento @@ plainto_tsquery(?, lower(unaccent(?)))", [$type, $search])
            ->orderByRaw("ts_rank(ts_documento, plainto_tsquery(?, lower(unaccent(?)))) DESC", [$type, $search]);
    }

    /**
     * Filtro de busca por tags e incrementa as vezes que foi buscada
     * @param Builder $query instância do query builder
     * @param $id Identificador único da palavra chave
     * @return void
     */
    public function scopeSearchTag(Builder $query, $tag_id)
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
     * @param Builder $query instância do query builder
     * @param $componentes ids dos componentes a buscar
     * @return void
     */
    public function scopeSearchByComponent(Builder $query, $componentes)
    {
        if (!$componentes) {
            return $query;
        }
        return $query->whereHas("componentes", function ($q) use ($componentes) {
            return $q->whereIn("id", explode(',', $componentes));
        });
    }

    /**
     * Buscar por colunas específicas
     * @param Builder $query instância do query builder
     * @param $column   coluna a buscar
     * @param $data     ids ou id de busca
     * @param $multiple busca com whereIn ou where
     * @return void
     */
    public function scopeSearchByColumn(Builder $query, $column, $data, $multiple = false)
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
     * @param Builder $query instância query builder
     * @param integer $canal_id Identificador único do canal
     * @return void
     */
    public function scopeSearchByCanal(Builder $query, $canal_id)
    {
        if (!$canal_id || $canal_id == 6) {
            return $query;
        }

        return $query->where('canal_id', $canal_id);
    }
    /**
     * Função que retorna modelo ordenado por quantidade de downloads, acessos, titulo ou data criação
     * @param Builder $query Instância query builder
     * @param string $by Ordem
     * @return void
     */
    public function scopeSortBy(builder $query, $by)
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
    /**
     * Função Statica retorna documento salvo
     * @param integer $id Identificador único do conteúdo
     * @return void
     */
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
    /**
     * Retorna conteúdos relacionados
     * @param Builder $query Instância query builder
     * @param integer $id Identificador único do conteúdo digital
     * @return void
     */
    public function scopeRelacionados(Builder $query, $id)
    {
        if (!$id) {
            return $query;
        }
        $tags_query = function ($q) {
            return $q->limit(2);
        };
        $conteudo = Conteudo::with(['tags' => $tags_query])->findOrFail($id);
        $tags = $conteudo->tags->implode('name', ', ');

        return Conteudo::whereRaw(
            "conteudos.ts_documento @@ plainto_tsquery('portuguese', lower(unaccent(?)))",
            [$tags]
        )->orWhereRaw(
            "conteudos.ts_documento @@ plainto_tsquery('simple', lower(unaccent(?)))",
            [$tags]
        )->where('id', '<>', $id);
    }

    /**
     * Retorna conteúdos mais baixados
     * @return DB
     */
    public function relatorioMaisBaixados()
    {
        return Conteudo::select([
            'title',
            'users.name as publisher',
            'tipos.name as type',
            'qt_downloads as quantity'
        ])
            ->join('users', 'users.id', '=', 'conteudos.user_id')
            ->join('tipos', 'tipos.id', '=', 'conteudos.tipo_id')
            ->orderByDesc("conteudos.qt_downloads")
            ->whereNotNull("qt_downloads")
            ->limit(100)
            ->get();
    }
    /**
     * Retorna conteúdos mais acessados
     * @return DB
     */
    public function relatorioMaisAcessados()
    {
        return Conteudo::select([
            'title',
            'users.name as publisher',
            'tipos.name as type',
            'qt_access as quantity'
        ])
            ->join('users', 'users.id', '=', 'conteudos.user_id')
            ->join('tipos', 'tipos.id', '=', 'conteudos.tipo_id')
            ->whereNotNull("qt_access")
            ->orderByDesc("conteudos.qt_access");
    }

    /**
     * Obtem array com os anos distintos que houveram conteúdos publicados
     * @return array
     */
    public function publicacaoAnos()
    {
        return DB::select("select  distinct date_part('year', created_at) as anopublicacao from conteudos order by 1 desc");
    }
    /**
     * Obtem os conteúdos publicados por ano
     * @param integer $ano Ano de publicação
     * @return void
     */
    public function conteudosPorAno($ano)
    {
        return Conteudo::select([
            'title',
            'users.name as publisher',
            'tipos.name as type',
            'qt_downloads as quantity'
        ])
            ->join('users', 'users.id', '=', 'conteudos.user_id')
            ->join('tipos', 'tipos.id', '=', 'conteudos.tipo_id')
            ->where(DB::raw("date_part('year', conteudos.created_at)"), $ano)
            ->get();
    }

    /**
     * Reorna todos objetos de conteudo de video que não possuem arquivos correspondentes de streaming
     * @return array $conteudos de video que não possuem arquivos de streaming do video convertidos ainda
     */
    public function conteudosSemStreamingFiles()
    {
        $conteudos = Conteudo::select(['id', 'title', 'tipo_id'])
            ->where("tipo_id", 5)
            ->get();
        $conteudoNoStreamingFile = [];
        foreach ($conteudos as $conteudo) {
            $videoFIleRef = $this->downloadFileConteudoReferencia($conteudo->id);
            if ($videoFIleRef) {
                $videoFIleRef = $this->streamingFileConteudoReferencia($conteudo->id);
                if (!$videoFIleRef) {
                    return;
                }
                $conteudoNoStreamingFile[] = $conteudo;
            }
        }
        return $conteudoNoStreamingFile;
    }
}
