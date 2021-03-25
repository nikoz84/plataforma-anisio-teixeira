<?php

namespace App\Http\Controllers;

use App\Models\Conteudo;
use App\Helpers\CachingModelObjects;
use App\Helpers\ContentVideoConvert;
use App\Helpers\ImageExtractionFromVideo;
use App\Http\Controllers\ApiController;
use App\Jobs\VideoStreamingConvert;
use App\Services\Destaques;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\FileSystemLogic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Streaming\FFMpeg;
use Illuminate\Support\Facades\Log;

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
            'conteudosRelacionados',
            'getConteudosRecentes',
            'incorporarConteudo',
            'conteudoWithNoStreamingFiles'
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
        $is_approved = 'true';
        
        if ($request->has('aprovados') && Auth::user()) {
            $is_approved = $request->query('aprovados', 'true');
        }
        $conteudos = $query->aprovados($is_approved)->with(['canal', 'tipo'])->paginate($request->query('limit', 6))->setPath("/conteudos?{$url}");
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

        $query->with(['canal'])
            ->where('is_site', 'true')
            ->where('is_approved', 'true')
            ->sortBy($request->query('ordenar', 'created_at'));
        $sites = $query->paginate($limit)
            ->setPath("/conteudos/sites?limit={$limit}");
        return $this->showAsPaginator($sites);
    }

    /**
     * Regras de validação
     * @return array
     */
    public function configRules(Request $request)
    {
        $configRules = [
            'license_id' => 'required',
            'canal_id' => 'required',
            'tipo_id' => 'required',
            'category_id' => 'nullable',
            'title' => 'required|min:5|max:120',
            'description' => 'required|min:140|max:5012',
            'options_site' => 'nullable|active_url',
            'tags' => 'required|array|min:3|max:8',
            'componentes' => 'required',
            'authors' => 'required',
            'source' => 'required',
            'terms' => 'required|boolean',
            'is_featured' => 'sometimes|boolean',
            'is_approved' => 'required|boolean',
            'is_site' => 'sometimes|boolean',
            'download' => ["sometimes","file", new \App\Rules\ValidExtensions($request)],
            'guias_pedagogicos' => ["sometimes|file|mimes:pdf,doc,docx,epub|max:120000"],
            'imagem_associada' => 'sometimes|image|mimes:jpeg,jpg,webp,png,gif,svg|max:2048',
            'visualizacao' => ["sometimes","file", new \App\Rules\ValidExtensions($request)]
        ];
        return $configRules;
    }

    /**
     * retorna mensagens de validações expecificas para o formulario de conteudo digital
     * @return array conjunto de mensagens para as validações do formulário de conteudo digital
     */
    protected function messagesRules()
    {
        $mensagens = ['componentes.required' => 'Selecione ao menos 1 componente curricular para este conteúdo'];
        return array_merge(parent::messagesRules(), $mensagens);
    }

    /**
     * Adiciona e valida novo conteúdo
     * @param $request \Illuminate\Http\Request
     * @return App\Traits\ApiReponser
     */
    public function create(Request $request)
    {
        $conteudo = new Conteudo;
        $this->authorize('create', $conteudo);
        $errorStatus = 400;
        $errors = [];
        $validator = Validator::make(
            $request->all(),
            $this->configRules($request)
        );
        try
        {
            if ($validator->fails()) {
                $errorStatus = 422;
                $errors = $validator->errors();
                throw new Exception("Não foi possível criar o conteúdo");
            }
            $role_id = Auth::user()->role->id;
            
            if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
                $conteudo->approving_user_id = Auth::user()->id;
                $conteudo->is_approved = $request->input('is_approved', false);
                $conteudo->is_featured = $request->input('is_featured', false);
            } else {
                $conteudo->setAttribute('approving_user_id', null);
                $conteudo->setAttribute('is_approved', false);
                $conteudo->setAttribute('is_featured', false);
            }
            $conteudo->user_id = Auth::user()->id;
            $conteudo->canal_id = $request->canal_id;
            $conteudo->tipo_id = $request->tipo_id;
            $conteudo->license_id = $request->license_id;
            $conteudo->category_id = $request->category_id;
            $conteudo->title = $request->title;
            $conteudo->description = $request->description;
            $conteudo->source = $request->source;
            $conteudo->authors = $request->authors;
            $conteudo->options = ['site' => $request->options_site];
            $conteudo->setAttribute('is_site', $request->input('is_site', false));
            $conteudo->qt_downloads = Conteudo::INIT_COUNT;
            $conteudo->qt_access = Conteudo::INIT_COUNT;
            if (!$conteudo->save()) {
                $errorStatus = 422;
                throw new Exception("Não foi possível cadastrar o conteúdo");
            }
            $conteudo->tags()->attach($request->tags);
            $conteudo->componentes()->attach(explode(',', $request->componentes));
            $conteudo::tsDocumentoSave($conteudo->id);
            $file = $this->storeFiles($request, $conteudo);
            if (!$file) 
            {
                throw new Exception('Não foi possível fazer upload de arquivos.');
            }
            $this->stremingVideoConvert($conteudo);
        }        
        catch (Exception $ex) 
        {
            Log::notice($ex);
            return $this->errorResponse($errors, $ex->getMessage(), $errorStatus);
        }
        return $this->showOne($conteudo, 'Conteúdo cadastrado com sucesso!!', 200);
    }

    /**
     * Atualiza o conteúdo.
     * @param  Integer $id
     * @return Json
     */
    public function update(Request $request, $id)
    {
        $conteudo = Conteudo::find($id);
        $this->authorize('update', $conteudo);
        $validator = Validator::make(
            $request->all(),
            $this->configRules($request)
        );
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar o conteúdo", 422);
        }
        
        $conteudo->fill(
            $request->except(
                [
                'approving_user_id',
                'is_approved',
                'is_featured',
                'options_site'
                ]
            )
        );

        $role_id = Auth::user()->role->id;
        
        if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
            $conteudo->approving_user_id = Auth::user()->id;
            $conteudo->is_approved = $request->input('is_approved', false);
            $conteudo->is_featured = $request->input('is_featured', false);
        } 
        else 
        {
            $conteudo->setAttribute('approving_user_id', null);
            $conteudo->setAttribute('is_approved', false);
            $conteudo->setAttribute('is_featured', false);
        }
        $conteudo->options = ['site' => $request->options_site];
        $conteudo->is_site = $request->input('is_site', false);
        if (!$conteudo->save()) 
        {
            return $this->errorResponse([], 'Não foi possível atualizar o conteúdo', 422);
        }
        $conteudo->tags()->sync($request->tags);
        $conteudo->componentes()->sync(explode(',', $request->componentes));
        Conteudo::tsDocumentoSave($conteudo->id);

        if ($request->has('download') || $request->has('guias_pedagogicos') ||
            $request->has('imagem_associada') || $request->has('visualizacao')) 
        {
           
            if (!$this->storeFiles($request, $conteudo)) {
                return $this->errorResponse([], 'Não foi possível fazer upload de arquivos.', 422);
            }
            $this->stremingVideoConvert($conteudo);
        }
        return $this->showOne($conteudo, 'Conteúdo editado com sucesso!!', 200);
    }

    /**
     * Apaga o conteúdo do banco de dados, com tags, componentes
     * @param $id integer
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
        $query->fullTextSearch($termo, 'tag');
        //$conteudos = $query->paginate($limit);
        $conteudos =  CachingModelObjects::search($query, $termo, $limit);
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
    public function getById(Request $request, $id)
    {
        $conteudo = new Conteudo();
        $query = $conteudo->query()->with([
            'tipo',
            'user',
            'canal',
            'tags',
            'license',
            'category',
            'componentes',
            'niveis',
        ]);
        $conteudo = CachingModelObjects::getById($query, $id);
        $conteudo->increment('qt_access', 1);

        $conteudo->save();
        
        return $this->showOne($conteudo);
    }

    /**
     * Incopora conteúdo em páginas externas
     * @param $id integer
     */
    public function incorporarConteudo($id)
    {
        $conteudo = Conteudo::findOrFail($id);
        $arquivos = $conteudo->getAttribute('arquivos');
        $download = null;
        $formato = null;
        $mega_bytes = null;
        $mime_type = null;

        if (isset($arquivos['download']->url)) {
            $download = $arquivos['download']->url;
            $formato = $arquivos['download']->extension;
            $mega_bytes = number_format($arquivos['download']->size / 1024, 2, ',', '.');
            $mime_type = $arquivos['download']->mime_type;
        } elseif (isset($arquivos['visualizacao']->url)) {
            $download = $arquivos['visualizacao']->url;
            $formato = $arquivos['visualizacao']->extension;
            $mega_bytes = number_format($arquivos['visualizacao']->size / 1024, 2, ',', '.');
            $mime_type = $arquivos['visualizacao']->mime_type;
        }
        return view(
            'incorporar.index',
            compact('download', 'formato', 'mega_bytes', 'mime_type', 'conteudo')
        );
    }
    
    /**
     * Responsável por criar arquivos de conteúdo
     */
    private function storeFiles($request, $conteudo = null)
    {
        $file = null;
        if ($conteudo && $conteudo->id) 
        {
            if ($request->has('download') && !is_null($request->download)) {
                $this->deleteFile("download", $conteudo->id);
                $this->deleteFile("streaming", $conteudo->id);
                $file = $this->saveFile($conteudo->id, [$request->download], 'download');
                if ($conteudo->tipo->id == 5) {
                    if ($file && !$request->has('imagem_associada')) {
                        $this->deleteFile("imagem-associada", $conteudo->id);
                        $imagemPath =  Storage::disk('conteudos-digitais')->path("imagem-associada");
                        $imageExtraction = new ImageExtractionFromVideo(
                            $this->downloadFileConteudoReferencia($conteudo->id),
                            $conteudo->id,
                            $imagemPath
                        );
                        $imageExtraction->realXtract(10);
                    }
                }
            }
            if ($request->has('guias_pedagogicos') && !is_null($request->guias_pedagogicos)) {
                $file = $this->saveFile($conteudo->id, [$request->guias_pedagogicos], 'guias-pedagogicos');
            }
            if ($request->has('imagem_associada') && !is_null($request->imagem_associada)) {
                $this->deleteFile("imagem-associada", $conteudo->id);
                $file = $this->saveFile($conteudo->id, [$request->imagem_associada], 'imagem-associada');
            }
        }
        return $file;
    }

    public function conteudosRelacionados(Request $request, $id)
    {
        $limit = $request->query('limit', 6);
        $query = Conteudo::query();
        $conteudos = $query
            ->relacionados($id)
            ->where('is_approved', 'true')
            ->limit($limit)->get();
        return $this->successResponse($conteudos);
    }
    public function getConteudosRecentes($slug)
    {
        
        $destaques = new Destaques(3);

        return $this->successResponse($destaques->getHomeDestaques($slug));
    }

    /**
     * Undocumented function
     * @param Conteudo $conteudo
     * @return void
     */
    protected function stremingVideoConvert(Conteudo $conteudo)
    {
        if($conteudo->tipo->id == 5)
        {
            $root = Storage::disk('conteudos-digitais')->path("streaming");
            $contentVideoConvert = new ContentVideoConvert( Conteudo::findOrFail($conteudo->id), FFMpeg::create(config('ffmpeg')));
            VideoStreamingConvert::dispatch($contentVideoConvert, $root)->delay(now()->addSeconds(15));
        }
    }

    /**
     * conteudos de video sem arquivos formato streaming
     * @return App\Traits\ApiResponser
     */
    public function conteudoWithNoStreamingFiles()
    {
        $conteudo = new Conteudo();
        return $conteudo->conteudosSemStreamingFiles();
    }
}