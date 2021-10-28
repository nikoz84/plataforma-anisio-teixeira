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


class Conteudo extends Model
{
    use FileSystemLogic, SoftDeletes, UserCan;

    const IS_SITE = 'false';
    const IS_APPROVED = 'false';
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

    protected $appends = ['image', 'excerpt', 'short_title', 'url_exibir', 'user_can', 'arquivos', 'formated_date', 'title_slug', 'download', 'guiaPedagogico'];
    protected $casts = ['options' => 'array',];
    protected $hidden = ['ts_documento'];

    /**
     * Seleciona o canal do conteúdo sem os campos adicionais
     * @param \App\Conteudo $conteufo
     * @return \App\Model\ApiResponser retorna json
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
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->select(['id', 'name']);
    }
    /**
     * Conteúdo tipo
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return App\Tipo
     */
    public function tipo()
    {
        //Tipo::$without_appends = true;

        return $this->hasOne(Tipo::class, 'id', 'tipo_id')
            ->select(['id', 'name']);
    }
    /**
     * Seleciona as Tags relacionadas
     * @param \App\Conteudo $conteudo
     * @return \App\Traits\ApiResponser retorna json
     * @return App\Tag
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'conteudo_tag', 'conteudo_id', 'tag_id')
            ->select(['id', 'name'])->orderBy('name');
    }
    /**
     * Seleciona os componentes curriculares
     * @param \App\Models\Contedudo $conteudo
     * @return \App\Traits\ApiResponser retorna json
     * @return App\Models\CurricularComponent
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
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return App\Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Seleciona niveis de ensino
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return App\NivelEnsino
     */
    public function niveis()
    {
        return $this->belongsToMany(
            NivelEnsino::class,
            'curricular_components',
            'id',
            'nivel_id'
        );
            //->whereRaw('nivel_id IS NOT NULL')
            //->with('nivel');
    }

    /**
     * Seleciona a licença relacionada
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return App\License
     */
    public function license()
    {
        return $this->hasOne(License::class, 'id', 'license_id');
    }


    public function setIsApprovedAttribute($value)
    {
        $user_can = $this->getUserCanAttribute();
        
        if ($user_can['create'] || $user_can['update']) {
            $this->attributes['is_approved'] = true;
        } else {
            $this->attributes['is_approved'] = false;
        }
    }
    
    public function setApprovingUserId($value)
    {
        $user_id = Auth::user()->id;

        $this->attributes['approving_user_id'] = $user_id ? $user_id : null;

    }
    /**
     * Adiciona novo atributo ao objeto que limita o tamanho da descrição
     * @return string cadena de caracteres
     */
    public function getExcerptAttribute()
    {
        return strip_tags(Str::words($this->description, 30));
    }
    /**
     * Adiciona novo atributo ao objeto que limita o tamanho da descrição
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return void
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
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return void
     */
    public function getFormatedDateAttribute()
    {
        return TransformDate::format($this['created_at']);
    }
    /**
     * Seleciona os Arquivos de download, visualizaçao e guias pedagógicas
     * desde o Trait App\Traits\File
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     *
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
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return void
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
     * recupera referencia ao arquivo de download
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return string referencia ao arquivo de download
     */
    public function getDownloadAttribute()
    {
        return $this->downloadFileConteudo($this->id);
    }
    
    /**
     * Adiciona atributo imagem associada ao objeto
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return string
     */
    public function getGuiaPedagogicoAttribute()
    {
        return $this->guiaPedagogicoFileConteudo($this->id);
    }

    /**
     * Adiciona atributo url_exibir
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @return string
     */
    public function getUrlExibirAttribute()
    {
        $slug = $this->canal()->pluck('slug')->first();
        return "/{$slug}/conteudo/exibir/" . $this['id'];
    }
    /**
     * Filtro para conteúdos Aprovados
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     */
    public function scopeApproved($query, $is_approved)
    {
        if (!$is_approved) {
            return $query;
        }
        return $query->where('is_approved', $is_approved);
    }
    /**
     * Filtro para full text search
     * @param $query  Eloquent\Query instance
     * @param $search termo de busca
     * @param $por    define se busca é por tag ou título
     * @return Eloquent\Query instance
     */
    public function scopeFullTextSearch($query, $search, $por)
    {
        if (!$search) {
            return $query;
        }
        $type = ($por == 'tag') ? "simple" : "portuguese";
        return $query->whereRaw("ts_documento @@ plainto_tsquery(?, lower(unaccent(?)))", [$type, $search])
            ->orderByRaw("ts_rank(ts_documento, plainto_tsquery(?, lower(unaccent(?)))) DESC", [$type, $search]);
    }

    /**
     * Filtro de busca por tags e incrementa as veces buscada
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
     * @param $query       Eloquent\Query
     * @param $componentes ids dos componentes a buscar
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
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @param $query    Eloquent\Query
     * @param $column   coluna a buscar
     * @param $data     ids ou id de busca
     * @param $multiple busca com where in ou where
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
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
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
     /**
      * Função que retorna scopo sorteado por id
      * @param \App\Conteudo $conteudo
      * @return \App\Model\ApiResponser retorna json
      * @param [type] $query
      * @param [type] $by
      * @return void
      */
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
    /**
     * Função Statica retorna documento salvo
     * @param \App\Conteudo $conteudo
     * @return \App\Model\ApiResponser retorna json
     * @param [type] $id
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
      * Retorna Scopo relacionado
      * @param \App\Conteudo $conteudo
      * @return \App\Model\ApiResponser retorna json
      */
    public function scopeRelacionados($query, $id)
    {
        if (!$id) {
            return $query;
        }
        $tags_query = function ($q) {
            return $q->limit(2);
        };
        $conteudo = Conteudo::with(['tags'=> $tags_query])->findOrFail($id);
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
      * Retorna Maximo de conteundo por downlaoad
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
     * obtem array com os anos distintos que houveram conteúdos publicados
     * @return array anos
     */
    public function publicacaoAnos()
    {
        return DB::select("select  distinct date_part('year', created_at) as anopublicacao from conteudos order by 1 desc");
    }

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
        $conteudos = Conteudo::select(['id','title', 'tipo_id'])
        ->where("tipo_id", 5)
        ->get();
        $conteudoNoStreamingFile=[];
        foreach($conteudos as $conteudo)
        {
            $videoFIleRef = $this->downloadFileConteudoReferencia($conteudo->id);
            if($videoFIleRef)
            {
                $videoFIleRef = $this->streamingFileConteudoReferencia($conteudo->id);
                if(!$videoFIleRef)
                $conteudoNoStreamingFile[] = $conteudo;
            }
        }
        return $conteudoNoStreamingFile;
    }
}