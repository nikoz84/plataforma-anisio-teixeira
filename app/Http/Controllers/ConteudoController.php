<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ConteudoController extends ApiController
{
    protected $conteudo;
    protected $request;

    public function __construct(Conteudo $conteudo, Request $request)
    {
        $this->middleware('jwt.verify')->except(['list', 'search', 'getById', 'getByTagId', 'getSitesTematicos']);
        $this->conteudo = $conteudo;
        $this->request = $request;
    }
    /**
     * Lista de conteúdos por canal
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $limit = $this->request->query('limit', 15);
        $orderBy = ($this->request->has('order')) ? $this->request->query('order') : 'created_at';
        $canal = $this->request->query('canal');

        $tipos = $this->request->get('tipos');
        $licencas = $this->request->query('licencas');
        $componentes = $this->request->query('componentes');
        $categoria = $this->request->query('categoria');

        $query = $this->conteudo::query();

        $query->when($tipos, function ($q, $tipos) {
            $data = "'[$tipos]'::jsonb";
            return $q->whereRaw("options->'tipo' <@  {$data}");
        });

        
        $query->when($canal != 6, function ($q, $canal) {
            return $q->where('canal_id', $canal);
        });
        
        $query->when($categoria, function ($q, $categoria) {
            return $q->where('category_id', $categoria);
        });

        $query->when($licencas, function ($q, $licencas) {
            return $q->whereIn('license_id', explode(',', $licencas));
        });
        $url = "limit={$limit}&canal={$canal}";
        $url .= "&tipos={$tipos}&componentes={$componentes}&categoria={$categoria}&licencas={$licencas}";


        $conteudos = $query->where('is_approved', 'true')
            ->with(['canal'])
            ->orderBy($orderBy, 'desc')
            ->paginate($limit)
            ->setPath("/conteudos?{$url}");

        return $this->showAsPaginator($conteudos);
    }

    private function getConteudosByIdCanal($canal_id)
    {
        $url = null;

        switch (true) {
            case $canal_id == 5:
                $url = '/conteudos/sites';
                break;
            case $canal_id == 6:
                $url = '/conteudos';
                break;
            case $canal_id == 9:
                $url = '/aplicativos';
                break;
            default:
                $url = '/conteudos?canal=${$canal_id}&site=false';
        }
        return $url;
    }

    /**
     * Lista de sites temáticos
     *
     * @return \Illuminate\Http\Response
     */
    public function getSitesTematicos()
    {
        $limit = $this->request->query('limit', 15);
        $orderBy = $this->request->query('order', 'created_at');

        $sitesTematicos = $this->conteudo::with('canal')
            ->where('is_site', 'true')
            ->where('is_approved', 'true')
            ->orderBy($orderBy, 'desc')
            ->paginate($limit)
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
            return $this->errorResponse($validator->errors(), "Não foi possível criar o conteúdo", 201);
        }

        $conteudo = $this->conteudo;

        $conteudo->user_id = Auth::user()->id;
        $conteudo->approving_user_id = Auth::user()->id;
        $conteudo->license_id = $this->request->license_id;
        $conteudo->canal_id = $this->request->canal_id;
        $conteudo->category_id = $this->request->category_id;
        $conteudo->title = $this->request->title;
        $conteudo->description = $this->request->description;
        $conteudo->authors = $this->request->authors;
        $conteudo->source = $this->request->source;
        $conteudo->is_featured = $this->request->is_featured;
        $conteudo->is_approved = $this->request->is_approved;
        $conteudo->is_site = $this->request->is_site;
        $conteudo->qt_downloads = $this->conteudo::INIT_COUNT;
        $conteudo->qt_access = $this->conteudo::INIT_COUNT;

        $conteudo->tags()->attach($this->request->tags);
        $conteudo->componentes()->attach($this->request->componentes);

        $conteudo->save();

        $this->saveOptions($conteudo->id);

        $conteudo::with([
            'user', 'canal', 'tags', 'license', 'componentes', 'niveis',
        ]);

        return $this->showOne($conteudo, 'Conteúdo cadastrado com sucesso!!', 200);
    }

    private function saveOptions($conteudo_id)
    {
        $tipo = DB::select('select * from tipos where id = ?', [$this->request->tipo_id]);

        $options = [
            'tipo' => [
                'id' => $tipo->id,
                'name' => $tipo->name
            ],
            'componentes' => [$this->request->componentes],
            'tags' => [$this->request->tags],
            'site' => $this->request->site,
            'guia' => $this->request->guia,
            'download' => null,
            'visualizacao' => null
        ];
        $conteudo = DB::select('select * from users where id = ?', [$conteudo_id]);

        $conteudo->options = $options;

        $conteudo->save();
    }

    public function saveFullTextSearch($conteudo_id)
    {
        $tags = $this->conteudo::with('tags')->whereRaw('id = ?', [$conteudo_id]);
        $componentes = $this->conteudo::with('componentes')->whereRaw('id = ?', [$conteudo_id]);
        $authorsSourceTitle = DB::select("select authors,source,title from conteudos")->whereRaw('id = ?', [$conteudo_id]);

        dd($tags);

        $sql = "
        setweight( to_tsvector( 'simple', (SELECT string_agg(lower(COALESCE(unaccent(t.nometag),'')), ' ' ) FROM conteudodigitaltag AS ct INNER JOIN tag t ON t.idtag = ct.idtag WHERE ct.idconteudodigital = cd.idconteudodigital)), 'A') ||
        setweight( to_tsvector( 'simple', lower( COALESCE( unaccent(cd.titulo), '') ) ), 'B' ) ||
        setweight( to_tsvector( 'portuguese', unaccent( lower( COALESCE( cd.fonte, '') ) ) ), 'C' ) ||
        setweight( to_tsvector( 'portuguese', unaccent( lower( COALESCE( cd.autores, '') ) ) ), 'C' ) ||
        setweight( to_tsvector( 'portuguese', unaccent(lower(
               regexp_replace(
               regexp_replace(
               regexp_replace( cd.descricao 
               , E'<.*?>', '', 'g')
               , E'&nbsp;', ' ', 'g')
               , E'[\\n\\r]+', ' ', 'g')
           ))),'D') AS ts_documento";
        $fullTextSearch = "";
        $conteudo->ts_documento = $fullTextSearch;

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
        $validator = Validator::make($this->request->all(), config("rules.conteudo"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar o conteúdo", 201);
        }

        $conteudo = $this->conteudo::with([
            'user', 'canal', 'tags', 'license', 'componentes', 'niveis',
        ])->find($id);

        $conteudo->fill($this->request->all());

        $conteudo->save();


        return $this->showOne($conteudo, 'Conteúdo editado com sucesso!!', 200);
    }
    public function createConteudoTags($id)
    {
        $conteudo = $this->conteudo::find($id);
        $conteudo->tags()->attach($this->request->get('tags'));
    }
    /**
     * Apaga o conteúdo do banco de dados.
     *
     * @param  Integer $id
     * @return Json
     */
    public function delete($id)
    {
        $conteudo = $this->conteudo::with('tags')->find($id);
        $conteudo->tags()->detach();
        $conteudo->componentes()->detach();
        $conteudo->niveis()->detach();

        $resp = [];

        if (!$conteudo) {
            return $this->errorResponse([], 'Não foi Possível deletar o conteúdo', 201);
        } else {
            return $this->showOne($conteudo->delete(), "Conteúdo de id: {$id} foi apagado com sucesso!!", 200);
        }
    }
    /**
     * Procura conteudos por full text search.
     *
     * @param  String $termo
     * @return Json
     */
    public function search($termo)
    {
        $limit = $this->request->query('limit', 15);
        $page = $this->request->query('page', 1);

        $conteudos = DB::table(DB::raw("conteudos as cd, plainto_tsquery('simple', lower(unaccent(?))) query"))
            ->select([
                'cd.id', 'cd.title',
                DB::raw('ts_rank_cd(cd.ts_documento, query) AS ranking'),
            ])
            ->whereRaw('query @@ cd.ts_documento')
            ->whereRaw('cd.is_approved = true')
            ->setBindings([$termo])
            ->orderBy('ranking', 'desc')
            ->paginate($limit);

        $conteudos->setPath("/conteudos/search/{$termo}?limit={$limit}");
        //$conteudos->hasMorePages();

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

        $conteudo = $this->conteudo::with([
            'user', 'canal', 'tags', 'license', 'componentes', 'niveis',
        ])->find($id);

        return $this->showOne($conteudo);
    }
    public function teste()
    {
        $conteudo = Conteudo::find(4);
        //$conteudo->tags()->detach([1,5]);

        return response()->json([
            'tags' => $conteudo->tags,
        ]);
    }
    /**
     * Lista de Conteúdos por Tag ID
     *
     * @param Integer $id
     * @return Json
     */
    public function getByTagId($id)
    {
        $limit = $this->request->query('limit', 15);

        $conteudos = $this->conteudo::select(['id', 'title'])->whereHas('tags', function ($query) use ($id) {
            $query->where('id', '=', $id);
        })->paginate($limit);

        $conteudos->setPath("/conteudos/tag/{$id}?limit={$limit}");

        DB::table('tags')->where('id', $id)->increment('searched', 1);

        return $this->showAsPaginator($conteudos);
    }
}
