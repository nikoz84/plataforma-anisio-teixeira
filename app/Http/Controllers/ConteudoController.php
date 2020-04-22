<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\Helpers\Autocomplete;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
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
        $request = $request;
    }

    /**
     * Lista de conteúdos por canal
     *
     * @param $request \Illuminate\Http\Request
     * 
     * @return App\Traits\ApiResponder
     */
    public function index(Request $request)
    {

        $limit = $request->query('limit', 6);
        $orderBy = $request->query('order', 'created_at');
        $canal = $request->query('canal', 6);
        $tipos          = $request->query('tipos');
        $licencas       = $request->query('licencas');
        $componentes    = $request->query('componentes');
        $categoria      = $request->query('categoria');
        $tag      = $request->query('tag');
        $por      = $request->query('por', 'tag');
        $busca    = $request->query('busca');
        $publicador    = $request->query('publicador');

        $query = Conteudo::query();

        // FILTRO X TIPO
        $query->when($tipos, function ($q, $tipos) {
            return $q->whereIn("tipo_id", explode(',', $tipos));
        });
        // FILTRO X PUUBLICADOR
        $query->when($publicador, function ($q, $request) {
            return $q->where('user_id', $request->query('publicador'));
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
        $query->when($canal != 6, function ($q, $request) {
            return $q->where('canal_id', $request->query('canal'));
        });
        // FILTRO X CATEGORIA
        $query->when($categoria, function ($q, $categoria) {
            return $q->where('category_id', explode(',', $categoria));
        });
        // FILTRO X COMPONENTES
        $query->when($componentes, function ($q, $componentes) {
            return $q->searchByComponent($componentes);
        });
        // FILTRO X LICENÇA
        $query->when($licencas, function ($q, $licencas) {
            return $q->whereIn('license_id', explode(',', $licencas));
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
     * @return App\Traits\ApiResponser
     */
    public function getSitesTematicos(Request $request)
    {
        $limit = $request->query('limit', 10);
        $orderBy = $request->query('order', 'created_at');

        $sitesTematicos = $this->conteudo::with(['canal'])
            ->where('is_site', 'true')
            ->where('is_approved', 'true')
            ->orderBy($orderBy, 'desc')
            ->paginate(10)
            ->setPath("/conteudos/sites?limit={$limit}");

        return $this->showAsPaginator($sitesTematicos);
    }
    /**
     * Regras de validação
     *
     * @return array
     */
    public function configRules()
    {
        return [
            'license_id' => 'required',
            'canal_id' => 'required',
            'tipo_id' => 'required',
            'category_id' => 'nullable',
            'title' => 'required|min:10|max:255',
            'description' => 'required|min:140',
            'tipo_id' => 'required',
            'options_site' => ['nullable', new \App\Rules\ValidUrl],
            'tags' => 'required',
            'componentes' => 'required',
            'authors' => 'required',
            'source' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'terms' => 'required|in:true,false',
            'is_featured' => 'nullable|in:true,false',
            'is_approved' => 'required|in:true,false',
            'is_site' => 'nullable|in:true,false',
            'download' => 'nullable|file|max:4500000',
            'guia' => 'nullable|file',
            'visualizacao' => 'nullable|file',
        ];
    }
    /**
     * Adiciona e valida novo conteúdo
     *
     * @param $request \Illuminate\Http\Request
     *
     * @return App\Traits\ApiReponser
     */
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->configRules()
        );

        if ($validator->fails()) {
            return $this->errorResponse(
                $validator->errors(),
                "Não foi possível criar o conteúdo",
                422
            );
        }

        $conteudo = new Conteudo;

        $conteudo->user_id = Auth::user()->id;
        $conteudo->setAttribute('approving_user_id', Auth::user());

        $conteudo->is_approved = $request->is_approved;
        $conteudo->tipo_id = $request->tipo_id;
        $conteudo->license_id = $request->license_id;
        $conteudo->canal_id = $request->canal_id;
        $conteudo->category_id = $request->category_id;

        // INFORMAÇÕES BÁSICAS
        $conteudo->title = $request->title;
        $conteudo->description = $request->description;
        $conteudo->authors = $request->authors;
        $conteudo->source = $request->source;
        // FL_DESTAQUE, FL_APROVADO, FL_SITE, QT_DOWNLOAD, QT_ACCESS
        $conteudo->options = ['site' => $request->options_site];
        $conteudo->setAttribute('is_featured', $request->is_featured);
        $conteudo->setAttribute('is_site', $request->is_site);

        // QUANTIDADE DE ACESSOS E DOWNLOADS
        $conteudo->qt_downloads = Conteudo::INIT_COUNT;
        $conteudo->qt_access = Conteudo::INIT_COUNT;



        dd($conteudo);
        if (!$conteudo->save()) {
            return $this->errorResponse([], "Não foi possível cadastrar o conteúdo", 422);
        }
        // PALAVRAS CHAVE, COMPONENTES CURRICULARES

        $conteudo->tags()->attach(explode(',', $request->tags));
        $conteudo->componentes()->attach(explode(',', $request->componentes));
        Conteudo::tsDocumentoSave($conteudo->id);

        $this->createFile($conteudo->id, $request->download);

        return $this->showOne($conteudo, 'Conteúdo cadastrado com sucesso!!', 200);
    }
    /**
     * Atualiza o conteúdo.
     *
     * @param  Integer $id
     * @return Json
     */
    public function update(Request $request, $id)
    {
        $conteudo = $this->conteudo::find($id);

        $this->authorize('update', $conteudo);

        $validator = Validator::make($request->all(), config("rules.conteudo"));
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar o conteúdo", 422);
        }
        $conteudo->fill($request->all());

        if (!$conteudo->save()) {
            return $this->errorResponse([], 'Não foi possível atualizar o conteúdo', 422);
        }
        $conteudo->tags()->sync(explode(',', $request->tags));
        $conteudo->componentes()->sync(explode(',', $request->componentes));
        Conteudo::tsDocumentoSave($conteudo->id);
        $this->createFile($conteudo->id, $request->download);

        return $this->showOne($conteudo, 'Conteúdo editado com sucesso!!', 200);
    }
    /**
     * Apaga o conteúdo do banco de dados, com tags, componentes
     *
     * @param $id integer
     *
     * @return App\Traits\ApiResponser
     */
    public function delete($id)
    {
        $conteudo = Conteudo::with(
            ['tags', 'componentes','niveis']
        )->find($id);

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
     * @param $request \Illuminate\Http\Request
     * @param $termo   string termo de busca
     *
     * @return App\Traits\ApiResponser
     */
    public function search(Request $request, $termo)
    {
        $limit = $request->query('limit', 6);

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
     * @param $id integer
     *
     * @return App\Traits\ApiResponser
     */
    public function getById($id)
    {
        $conteudo = Conteudo::with([
            'tipo',
            'user',
            'canal',
            'tags',
            'license',
            'category',
            'componentes',
            'niveis',
        ])->find($id);

        $conteudo->increment('qt_access', 1);

        return $this->showOne($conteudo);
    }
}
