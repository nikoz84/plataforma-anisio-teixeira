<?php

namespace App\Http\Controllers;

use App\Helpers\ResizeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
use App\Models\Aplicativo;
use App\Helpers\CachingModelObjects;
use App\Http\Requests\AplicativoRequest;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Traits\FileSystemLogic;

class AplicativoController extends ApiController
{ 

    use FileSystemLogic;
    /**
     * Metodo construtor com passagem de tres parametros
     */
    public function __construct(Aplicativo $aplicativo, Request $request, Storage $storage)
    {
        $this->middleware('jwt.auth')->except(['index', 'search', 'getById', 'categories']);
        $this->aplicativo = $aplicativo;
        $this->request = $request;
        $this->storage = $storage;
    }
    /**
     * Display a listing of the resource.
     * Lista Informações do palicativo no banco de dados
     * @param\App\Aplicativo $aplicativo
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = $this->request->query('limit', 6);
        $category = $this->request->query('categoria');

        $query = $this->aplicativo::query();

        $query->when($category, function ($q, $category) {
            return $q->where('category_id', $category);
        });

        $apps = $query->with(['category', 'canal', 'user'])
            ->orderBy('updated_at', 'desc')
            ->paginate($limit)
            ->setPath("/aplicativos?categoria={$category}&limit={$limit}");
        return $this->showAsPaginator($apps);
    }

    /**
     * Cria um novo aplicativo no banco de dados
     *
     *@param \App\Aplicativo $aplicativo
     *@return \App\Controller\ApiResponser retorna json
     */
    public function create(AplicativoRequest $request)
    {
        $this->authorize('create', Aplicativo::class);
        
        $aplicativo = new Aplicativo;
        $aplicativo->fill($request->validated());
        
        if (!$aplicativo->save()) {
            $this->errorResponse([], "Erro no prenchimento de dados.", 422);
        }
        
        
        $aplicativo->tags()->attach($request->tags);
            
        if ($request->imagemAssociada) {
            $fileImg = $this->saveFile($aplicativo->id, [$request->imagemAssociada], 'imagem-associada', 'aplicativos-educacionais');
            if (!$fileImg) {
                return $this->errorResponse([], "Não foi possível salvar imagem. Tente novamente mais tarde.", 422);
            }
        }
        
        return $this->successResponse($aplicativo, 'Aplicativo cadastrado com sucesso!', 200);
    }
    
    /**
     * Cria Arquivo de imagem
     */
    private function createFile($id, $image)
    {
        $fileName = "{$id}.{$image->guessExtension()}";
        $path = $image->storeAs('imagem-associada', $fileName, 'aplicativos-educacionais');
        $image = new ResizeImage();

        $filePath = $this->storage::disk('aplicativos-educacionais')->url($path);
        $dir = $this->storage::disk('aplicativos-educacionais')->getDriver()->getAdapter()->getPathPrefix() . "imagem-associada/";
        $image->resize($filePath, $fileName, $dir);
    }
    /**
     * Atualiza aplicativo no banco de dados
     *
     * @param int $id identificador único
     * @param  \App\Aplicativo  $aplicativo
     * @return \App\Traits\ApiResponser retorna json
     */
    public function update(AplicativoRequest $request, $id)
    {
        $aplicativo = Aplicativo::findOrFail($id);
        
        $this->authorize('update', $aplicativo);

        
        $aplicativo->fill($request->validated());
        
        if (!$aplicativo->save()) {
            return $this->errorResponse([], "Não foi possível atualizar o aplicativo", 422);
        }
        
        $aplicativo->tags()->sync($request->tags);

        if ($request->imagemAssociada) {
            if ($aplicativo->referenciaImagemAssociada()) {
                unlink($aplicativo->referenciaImagemAssociada());
            }
            $fileImg = $this->saveFile($aplicativo->id, [$this->request->imagemAssociada], 'imagem-associada', 'aplicativos-educacionais');
            if (!$fileImg) {
                throw new Exception("Não foi possível salvar imagem. Tente novamente mais tarde.", 501);
            }
        }

        return $this->successResponse($aplicativo, "Aplicativo atualizado com sucesso!!", 200);
    }
    /**
     * Remove the specified resource from storage.
     * Remove o aplicativo e retorna um erro.
     * @return \Illuminate\Http\Response json.
     */
    public function delete($id)
    {
        $aplicativo = $this->aplicativo::findOrFail($id);
        $aplicativo->tags()->detach();

        if (!$aplicativo->delete()) {
            $this->errorResponse([], 'não foi possível deletar!!', 422);
        }
        return $this->successResponse([], 'Aplicativo deletado com sucesso!!', 200);
    }
    
    /**
     * Metodo que faz uma busca de reposta no banco de dados.
     * @param \App\Aplicativo $aplicativo
     * @return \App\Controller\ApiResponser retorna json.
     */
    public function search(Request $request, $termo)
    {
        $limit = $request->query('limit', 15);
        $search = "%{$termo}%";
        $aplicativos = Aplicativo::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->with(['category', 'canal'])
            ->paginate($limit);
        
        $aplicativos->setPath("/aplicativos/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator(
            $aplicativos,
            "Resultados da busca pelo termo: {$termo}",
            200
        );
    }

    /**
     * Seleciona um recurso por id
     * @param int $id
     * @return string json
     */
    public function getById($id)
    {
        $aplicativo = $this->aplicativo::with(['tags', 'category', 'user', 'canal'])->find($id);
        $increment = $aplicativo->options['qt_access'] + 1;
        $aplicativo->setAttribute('options->qt_access', $increment); // json attribute
        $aplicativo->save();
        if (!$aplicativo) {
            $this->errorResponse([], 'Não encontrado', 422);
        }

        return $this->showOne($aplicativo, '', 200);
    }
}
