<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\Helpers\Autocomplete;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\FileSystemLogic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConteudoController extends ApiController
{
    use FileSystemLogic;
    
    public function __construct(Request $request)
    {
        $this->middleware('auth:api')->except([
            'index',
            'search',
            'getById',
            'getByTagId',
            'getSitesTematicos',
            'incorporarConteudo',
            'storeFiles'
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
        $query = Conteudo::query();

        $query->searchByColumn('user_id', $request->query('publicador'))
            ->searchByColumn('category_id', $request->query('categoria'))
            ->searchByColumn('tipo_id', $request->query('tipos'), true)
            ->searchByColumn('license_id', $request->query('licencas'), true)
            ->fullTextSearch(
                $request->query('busca'),
                $request->query('por', 'tag')
            )
            ->searchTag($request->query('tag'))
            ->searchByCanal($request->query('canal', 6))
            ->searchByComponent($request->query('componentes'))
            ->sortBy($request->query('ordenar', 'data'));

        $url = http_build_query($request->except('page'));

        $conteudos = $query->where('is_approved', 'true')
            ->with(['canal', 'tipo'])
            ->paginate($request->query('limit', 6))
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
        $query = Conteudo::query();

        $query::with(['canal'])
            ->where('is_site', 'true')
            ->where('is_approved', 'true')
            ->sortBy($request->query('ordenar', 'created_at'));

        $sites = $query->paginate($limit)
            ->setPath("/conteudos/sites?limit={$limit}");

        return $this->showAsPaginator($sites);
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
            'guias-pedagogicos' => 'nullable|file|max:1000000',
            'imagem-associada' => 'nullable|file|max:2000',
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

        $conteudo->title = $request->title;
        $conteudo->description = $request->description;
        $conteudo->authors = $request->authors;
        $conteudo->source = $request->source;
        $conteudo->options = ['site' => $request->options_site];
        $conteudo->setAttribute('is_featured', $request->is_featured);
        $conteudo->setAttribute('is_site', $request->is_site);
        $conteudo->qt_downloads = Conteudo::INIT_COUNT;
        $conteudo->qt_access = Conteudo::INIT_COUNT;

        if (!$conteudo->save()) {
            return $this->errorResponse([], "Não foi possível cadastrar o conteúdo", 422);
        }

        $conteudo->tags()->attach(explode(',', $request->tags));
        $conteudo->componentes()->attach(explode(',', $request->componentes));
        $conteudo::tsDocumentoSave($conteudo->id);

        //$this->createFile($conteudo->id, $request->download);
        $this->storeFiles($request);

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
            ['tags', 'componentes', 'niveis']
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
            return $q->fullTextSearch($termo, 'tag');
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
    /**
     * Incopora conteuúdo em páginas externas
     *
     * @param $id integer
     */
    public function incorporarConteudo($id)
    {
        $conteudo = Conteudo::find($id);
        $arquivos = $conteudo->getAttribute('arquivos');

        $download = $arquivos['download']->url;
        $formato = $arquivos['download']->extension;
        $mega_bytes = number_format($arquivos['download']->size / 1024, 2, ',', '.');
        $mime_type = $arquivos['download']->mime_type;

        return view(
            'conteudos_digitais.index',
            compact('download', 'formato', 'mega_bytes', 'mime_type', 'conteudo')
        );
    }

    /**
     * Responsável por criar arquivos de conteúdo
     *
     * @return \Illuminate\Http\Response
     */
    public function storeFiles(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "id"   => "required",
                "local" => "required",
                "file.*" => "required|mimes:{$this->mimeTypes()}|max:100000"
            ]
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível salvar arquivo.", 422);
        }

        $file = null;

        switch ($request->local) {
            case 'download':
                $file = $this->saveFile($request->id, $request->file, $request->local);
                break;
            case 'guias-pedagogicos':
                $file = $this->saveFile($request->id, $request->file, $request->local);
                break;
            case 'imagem-associada':
                $file = $this->saveFile($request->id, $request->file, $request->local);
                break;
            default:
                return $this->errorResponse([], 'arquivo não encontrado', 404);
                break;
        }

        if ($file) {
            return $this->successResponse([], 'arquivo criado com sucesso!', 200);
        } else {
            return $this->errorResponse([], 'Não foi possível criar arquivo.', 500);
        }
    }
}
