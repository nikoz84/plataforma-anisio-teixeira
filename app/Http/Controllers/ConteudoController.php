<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\Tag;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ConteudoController extends ApiController
{
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
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;
        $canal = $this->request->query('canal');

        $tipos = $this->request->get('tipos');
        $licencas = $this->request->query('licencas');
        $componentes = $this->request->query('componentes');
        $categorias = $this->request->query('categorias');
        /*
        return response()->json([
        'tipos' => $tipos,
        'componentes'=> $componentes,
        'licencas' => $licencas,
        'categorias' => $categorias
        ]);
         */
        $query = $this->conteudo::query();
        $query->when($canal, function ($q, $canal) {
            return $q->where('canal_id', $canal)
                ->where('is_approved', 'true');
        });

        $query->when($tipos, function ($q, $tipos) {
            return $q->whereIn('options->tipo->id', explode(',', $tipos));
        });
        $url = "limit={$limit}&canal={$canal}";
        $url .= "&tipos={$tipos}&componentes={$componentes}&categorias={$categorias}&licencas={$licencas}";

        $conteudos = $query->with('canal')
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
        $validar = $this->validar($this->request, config('form.conteudo'));

        if ($validar->error) {
            return $this->errorResponse($validar->errors, "Não foi possível cadastrar o conteúdo", 201);
        }

        $conteudo = $this->conteudo;

        $conteudo->user_id = Auth::user()->id;
        $conteudo->approving_user_id = Auth::user()->id;
        $conteudo->license_id = $this->request->get('license_id');
        $conteudo->canal_id = $this->request->get('canal_id', '');
        $conteudo->title = $this->request->get('title');
        $conteudo->description = $this->request->get('description');
        $conteudo->authors = $this->request->get('authors');
        $conteudo->source = $this->request->get('source');
        $conteudo->is_featured = $this->request->get('is_featured');
        $conteudo->is_approved = $this->request->get('is_approved');
        $conteudo->is_site = $this->request->get('is_site');
        $conteudo->options = json_decode($this->request->get('options'), true);

        $conteudo->save();

        $conteudo::with([
            'user', 'canal', 'tags', 'license', 'componentes', 'niveis',
        ]);

        return $this->showOne($conteudo, 'Conteúdo cadastrado com sucesso!!', 200);
    }

    /**
     * Atualiza o conteúdo.
     *
     * @param  Integer $id
     * @return Json
     */
    public function update($id)
    {
        $validar = $this->validar($this->request, config('form.conteudo'));

        if ($validar->error) {
            return $this->errorResponse($validar->errors, "Não foi possível atualizar o conteúdo", 201);
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
