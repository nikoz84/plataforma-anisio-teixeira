<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\Helpers\Autocomplete;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\FileSystemLogic;
use Illuminate\Http\Request;

class ConteudoController extends ApiController
{
    use FileSystemLogic;

    public function __construct(Request $request)
    {
        $this->middleware('jwt.verify')->except([
            'index',
            'search',
            'getById',
            'getByTagId',
            'getSitesTematicos'
        ]);
        $this->request = $request;
    }

    /**
     * Lista de conteúdos por canal
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $limit = $this->request->query('limit', 6);
        $orderBy = $this->request->query('order', 'created_at');
        $canal = $this->request->query('canal', 6);
        $tipos          = $this->request->query('tipos');
        $licencas       = $this->request->query('licencas');
        $componentes    = $this->request->query('componentes');
        $categoria      = $this->request->query('categoria');
        $tag      = $this->request->query('tag');
        $por      = $this->request->query('por', 'tag');
        $busca    = $this->request->query('busca');
        $publicador    = $this->request->query('publicador');

        $query = Conteudo::query();

        // FILTRO X TIPO
        $query->when($tipos, function ($q, $tipos) {
            return $q->where("tipo_id", $tipos);
        });
        // FILTRO X PUUBLICADOR
        $query->when($publicador, function ($q) {
            return $q->where('user_id', $this->request->query('publicador'));
        });
        // FILTRO BUSCA FULL TEXT SEARCH
        $query->when($busca, function ($q) use ($busca, $por) {
            return $q->search($busca, $por);
        });
        // FILTRO X TAG
        $query->when($tag, function ($q, $tag) {
            return $q->searchTag($tag);
        });
        // FILTRO X CANAL
        $query->when($canal != 6, function ($q) {
            return $q->where('canal_id', $this->request->query('canal'));
        });
        // FILTRO X CATEGORIA
        $query->when($categoria, function ($q, $categoria) {
            return $q->where('category_id', $categoria);
        });
        // FILTRO X COMPONENTES
        $query->when($componentes, function ($q, $componentes) {
            return $q->searchByComponent($componentes);
        });
        // FILTRO X LICENÇA
        $query->when($licencas, function ($q, $licencas) {
            return $q->whereIn('license_id', $licencas);
        });

        $url = "busca={$busca}&limit={$limit}&canal={$canal}&tag={$tag}&publicador=$publicador";
        $url .= "&tipos={$tipos}&componentes={$componentes}&categoria={$categoria}&licencas={$licencas}";

        $conteudos = $query->where('is_approved', 'true')
            ->with(['canal', 'tipo'])
            ->orderBy($orderBy, 'desc')
            ->paginate($limit)
            ->setPath("/conteudos?{$url}");

        return $this->showAsPaginator($conteudos);
    }
    /**
     * Lista de sites temáticos
     *
     * @return \Illuminate\Http\Response
     */
    public function getSitesTematicos()
    {
        $limit = $this->request->query('limit', 10);
        $orderBy = $this->request->query('order', 'created_at');

        $sitesTematicos = $this->conteudo::with(['canal'])
            ->where('is_site', 'true')
            ->where('is_approved', 'true')
            ->orderBy($orderBy, 'desc')
            ->paginate(10)
            ->setPath("/conteudos/sites?limit={$limit}");

        return $this->showAsPaginator($sitesTematicos);
    }
    /**
     * Adiciona e valida novo conteúdo
     *
     * @return Json
     */
    public function create()
    {
        $validator = Validator::make($this->request->all(), config("rules.conteudo"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o conteúdo", 422);
        }

        $conteudo = new Conteudo;

        $conteudo->user_id = Auth::user()->id;
        $conteudo->approving_user_id = Auth::user()->id;

        $conteudo->license_id = $this->request->license_id;
        $conteudo->canal_id = $this->request->canal_id;
        $conteudo->category_id = $this->request->category_id;
        // INFORMAÇÕES BÁSICAS
        $conteudo->title = $this->request->title;
        $conteudo->description = $this->request->description;
        $conteudo->authors = $this->request->authors;
        $conteudo->source = $this->request->source;
        // FL_DESTAQUE, FL_APROVADO, FL_SITE, QT_DOWNLOAD, QT_ACCESS
        $conteudo->is_approved = $this->request->has('is_approved') ?
            $this->request->is_approved : Conteudo::IS_APPROVED;
        $conteudo->is_featured = $this->request->has('is_featured') ?
            $this->request->is_featured : Conteudo::IS_FEATURED;
        $conteudo->is_site = $this->request->has('is_site') ?
            $this->request->is_site : Conteudo::IS_SITE;
        // QUANTIDADE DE ACESSOS E DOWNLOADS
        $conteudo->qt_downloads = $this->conteudo::INIT_COUNT;
        $conteudo->qt_access = $this->conteudo::INIT_COUNT;

        if (!$conteudo->save()) {
            return $this->errorResponse([], "Não foi possível cadastrar o conteúdo", 422);
        }
        // PALAVRAS CHAVE, COMPONENTES CURRICULARES
        $conteudo->tags()->attach(explode(',', $this->request->tags));
        $conteudo->componentes()->attach(explode(',', $this->request->componentes));

        $this->saveFullTextSearch($conteudo->id);

        $this->saveOptions($conteudo->id);

        return $this->showOne($conteudo, 'Conteúdo cadastrado com sucesso!!', 200);
    }
    private function saveOptions($conteudo_id)
    {
        $tipo = collect(DB::select('select * from tipos where id = ?', [$this->request->tipo_id]))->first();
        $conteudo = $this->conteudo::find($conteudo_id);

        $arr_file = $this->createFile($conteudo->id, $this->request->download);
        $options = [
            'tipo'          => $tipo->id,
            'componentes'   => [$this->request->componentes],
            'tags'          => [$this->request->tags],
            'site'          => $this->request->site, // URL DO SITE
            'guia'          => $this->request->guia, // ARQUIVO DE GUIA PEDAGOGICA
            'download'      => $this->request->hasFile('download') ? $arr_file : null,
            'visualizacao'  => null, // ARQUIVO DE VISUALIZACAO - $this->request->visualizacao
        ];

        $conteudo->options = $options;
        $conteudo->save();
    }

    private function saveFullTextSearch($conteudo_id)
    {
        //$componentes = $this->conteudo::with('componentes')->whereRaw('id = ?', [$conteudo_id]);
        $conteudo = $this->conteudo::find($conteudo_id);

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
            ->where('id', '=', $conteudo_id)
            ->get()
            ->first();

        $conteudo->ts_documento = $fullTextSearch->ts_documento;
        $conteudo->save();
    }

    /**
     * Atualiza o conteúdo.
     *
     * @param  Integer $id
     * @return Json
     */
    public function update($id)
    {
        $conteudo = $this->conteudo::find($id);

        $this->authorize('update', $conteudo);

        $validator = Validator::make($this->request->all(), config("rules.conteudo"));
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar o conteúdo", 422);
        }
        $conteudo->fill($this->request->all());
        if ($conteudo->save()) {
            $this->createFile($id, $this->request->download);
            $this->saveOptions($id);
            $conteudo->tags()->sync(explode(',', $this->request->tags));
        }
        return $this->showOne($conteudo, 'Conteúdo editado com sucesso!!', 200);
    }

    private function createConteudoTags($id)
    {
        $conteudo = $this->conteudo::find($id);
        $conteudo->tags()->attach($this->request->get('tags'));
    }
    /**
     * Apaga o conteúdo do banco de dados, com tags, componentes
     *
     * @param  Integer $id
     * @return Json
     */
    public function delete($id)
    {
        $conteudo = $this->conteudo::with('tags')->find($id);

        $this->authorize('delete', $conteudo);

        $conteudo->tags()->detach();
        $conteudo->componentes()->detach();
        $conteudo->niveis()->detach();
        if (!$conteudo->delete()) {
            return $this->errorResponse([], 'Não foi Possível deletar o conteúdo', 422);
        }

        return $this->successResponse([], "Conteúdo de id: {$id} foi apagado com sucesso!!", 200);
    }
    /**
     * Procura conteudos por full text search.
     *
     * @param  String $termo
     * @return Json
     */
    public function search($termo)
    {
        $limit = $this->request->query('limit', 6);

        $query = Conteudo::query();

        $query->when($termo, function ($q) use ($termo) {
            return $q->search($termo, 'tag');
        });
        $conteudos = $query->paginate($limit);

        $conteudos->setPath("/conteudos/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator($conteudos);
    }
    /**
     * Procura um conteúdo por id
     *
     * @param Integer $id
     * @return Json
     */
    public function getById($id)
    {
        $conteudo = Conteudo::with([
            'tipo', 'user', 'canal', 'tags', 'license', 'componentes', 'niveis',
        ])->find($id);

        $conteudo->increment('qt_access', 1);

        return $this->showOne($conteudo);
    }
}
