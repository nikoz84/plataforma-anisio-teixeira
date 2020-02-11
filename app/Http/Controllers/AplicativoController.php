<?php

namespace App\Http\Controllers;

use App\Helpers\ResizeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
use App\Aplicativo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AplicativoController extends ApiController
{
    public function __construct(Aplicativo $aplicativo, Request $request, Storage $storage)
    {
        $this->middleware('jwt.verify')->except(['index', 'search', 'getById', 'categories']);
        $this->aplicativo = $aplicativo;
        $this->request = $request;
        $this->storage = $storage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = $this->request->query('limit', 15);
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
     * Cria um novo aplicativo.
     *
     *
     */
    public function create()
    {
        $this->authorize('create', Aplicativo::class);

        $validator = Validator::make($this->request->all(), config("rules.aplicativo"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível adicionar o aplicativo", 422);
        }
        $aplicativo = $this->aplicativo;

        $aplicativo->name = $this->request->name;
        $aplicativo->canal_id =  $this->aplicativo::CANAL_ID;
        $aplicativo->category_id = $this->request->category_id;
        $aplicativo->user_id = Auth::user()->id;
        $aplicativo->url = $this->request->url;
        $aplicativo->description = $this->request->description;

        $is_featured = $this->request->options_is_featured === 'true' ? true : false;
        $aplicativo->setAttribute('options->is_featured', $is_featured);
        $aplicativo->setAttribute('options->qt_access', $this->aplicativo::QT_ACCESS_INIT);

        if (!$aplicativo->save()) {
            return $this->errorResponse([], "Não foi possível criar o aplicativo", 422);
        }

        $aplicativo->tags()->attach($this->request->tags);

        if ($this->request->has('image')) {
            $this->createFile($this->aplicativo->id, $this->request->file('image'));
        }

        return $this->successResponse($aplicativo, 'Aplicativo cadastrado com sucesso!', 200);
    }
    /**
     * Cria Arquivo de imagem
     */
    private function createFile($id, $image)
    {
        $fileName = "{$id}.{$image->guessExtension()}";
        return $this->successResponse($fileName, 'teste', 200);
        $path = $this->request->file('image')
            ->storeAs('imagem-associada', $fileName, 'aplicativos-educacionais');
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
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $aplicativo = Aplicativo::findOrFail($id);

        $this->authorize('update', [$aplicativo]);

        $validator = Validator::make($this->request->all(), config("rules.aplicativo"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar o aplicativo", 422);
        }

        $aplicativo->name = $this->request->name;
        $aplicativo->canal_id = $aplicativo::CANAL_ID;
        $aplicativo->description = $this->request->description;
        $is_featured = $this->request->options_is_featured === 'true' ? true : false;
        $aplicativo->setAttribute('options->is_featured', $is_featured);
        $aplicativo->category_id = $this->request->category_id;

        $aplicativo->tags()->sync($this->request->tags);

        if (!$aplicativo->save()) {
            return $this->errorResponse([], "Não foi possível atualizar o aplicativo", 422);
        }
        if ($this->request->has('image')) {
            $this->createFile($aplicativo->id, $this->request->file('image'));
        }

        return $this->successResponse($aplicativo, "Aplicativo atualizado com sucesso!!", 200);
    }
    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response json
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
     *
     * @param Integer $id
     * @return json
     */
    public function getById($id)
    {
        $aplicativo = $this->aplicativo::with(['tags', 'category', 'user', 'canal'])
            ->find($id);
        //$canal = \App\Canal::find(9);
        //$canal->setAttribute('options->has_categories', true);
        //$canal->save();
        $increment = $aplicativo->options['qt_access'] + 1;

        $aplicativo->setAttribute('options->qt_access', $increment); // json attribute
        $aplicativo->save();

        if (!$aplicativo) {
            $this->errorResponse([], 'Não encontrado', 422);
        }

        return $this->showOne($aplicativo, '', 200);
    }
}
