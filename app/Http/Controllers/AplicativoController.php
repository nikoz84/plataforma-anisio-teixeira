<?php

namespace App\Http\Controllers;

use App\Helpers\ResizeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
use App\Aplicativo;
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

        $apps = $query->with(['category', 'canal'])
            ->orderBy('created_at', 'desc')
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
    public function create()
    {
        $this->authorize('create', Aplicativo::class);
        $validator = Validator::make(
            $this->request->all(),
            $this->configRules()
        );
        $data = [];
        try {
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new  Exception("Erro no preenchimento dos dados");
            }
            $aplicativo = $this->aplicativo;
            $aplicativo->canal_id = Aplicativo::CANAL_ID;
            $aplicativo->user_id = Auth::user()->id;
            $aplicativo->url = $this->request->url;
            $aplicativo->options  = json_decode($this->request->options, true);
            $aplicativo->options = [
                'qt_access' => Aplicativo::QT_ACCESS_INIT,
                'is_featured' => $this->request->options_is_featured
            ];
            if (!$aplicativo->save()) {
                throw new  Exception("Erro no preenchimento dos dados");
            }
            $aplicativo->tags()->attach($this->request->tags);
            if ($this->request->imagemAssociada) {
                $fileImg = $this->saveFile($aplicativo->id, [$this->request->imagemAssociada], 'imagem-associada', 'aplicativos-educacionais');
                if (!$fileImg) {
                    throw new Exception("Não foi possível salvar imagem. Tente novamente mais tarde.", 501);
                }
            }
        } catch (Exception $ex) {
            return $this->errorResponse($data, $ex->getMessage(), 422);
        }
        return $this->successResponse($aplicativo, 'Aplicativo cadastrado com sucesso!', 200);
    }
    /**
     * Regras de validação
     */
    private function configRules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'description' => 'required|min:140',
            'url' => 'required|active_url',
            'options_is_featured' => 'boolean',
            'tags' => 'required|array|between:3,10',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,svg|max:1024'
        ];
    }
    /**
     * Cria Arquivo de imagem
     */
    private function createFile($id, $image)
    {
        $fileName = "{$id}.{$image->guessExtension()}";
        $path = $image
            ->storeAs('imagem-associada', $fileName, 'aplicativos-educacionais');
        $image = new ResizeImage();

        $filePath = $this->storage::disk('aplicativos-educacionais')->url($path);
        $dir = $this->storage::disk('aplicativos-educacionais')
            ->getDriver()->getAdapter()->getPathPrefix() . "imagem-associada/";
        $image->resize($filePath, $fileName, $dir);
    }
    /**
     * Atualiza aplicativo no banco de dados
     *
     * @param int $id identificador único
     * @param  \App\Aplicativo  $aplicativo
     * @return \App\Traits\ApiResponser retorna json
     */
    public function update($id)
    {
        $aplicativo = Aplicativo::findOrFail($id);
        
        $this->authorize('update', $aplicativo);
        $validator = Validator::make(
            $this->request->all(),
            $this->configRules()
        );
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar o aplicativo", 422);
        }
        $aplicativo->name = $this->request->name;
        $aplicativo->canal_id = $aplicativo::CANAL_ID;
        $aplicativo->url = $this->request->url;
        $aplicativo->description = $this->request->description;
        $is_featured = $this->request->options_is_featured == '1' ? true : false;
        $aplicativo->setAttribute('options->is_featured', $is_featured);
        $aplicativo->category_id = Aplicativo::CANAL_ID;

        $aplicativo->tags()->sync($this->request->tags);

        if (!$aplicativo->save()) {
            return $this->errorResponse([], "Não foi possível atualizar o aplicativo", 422);
        }
        if ($this->request->imagemAssociada) {
            if ($aplicativo->refenciaImagemAssociada()) {
                unlink($aplicativo->refenciaImagemAssociada());
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
