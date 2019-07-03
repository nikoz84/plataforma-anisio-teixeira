<?php

namespace App\Http\Controllers;

use App\Aplicativo;
use App\Helpers\ResizeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;

class AplicativoController extends ApiController
{
    public function __construct(Aplicativo $aplicativo, Request $request, Storage $storage)
    {
        $this->middleware('jwt.verify')->except(['list', 'search', 'getById']);
        $this->aplicativo = $aplicativo;
        $this->request = $request;
        $this->storage = $storage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $limit = $request->query('limit', 15);
        $page = $request->query('page', 1);
        $category = $request->query('categoria');

        $query = $this->aplicativo::query();

        $query->when($category, function ($q, $category) {
            return $q->where('category_id', $category);
        });

        $apps = $query->with(['category', 'canal'])
            ->orderBy('name', 'desc')
            ->paginate($limit)
            ->setPath("/aplicativos?categoria={$category}&limit={$limit}");

        return $this->showAsPaginator($apps, 'Aplicativos Educacionais', 200);
    }



    /**
     * Cria um novo aplicativo.
     *
     *
     */
    public function create()
    {
        $validator = Validator::make($this->request->all(), config("rules.aplicativo"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o conteúdo", 201);
        }


        $id = $this->aplicativo::create($this->request);

        $path = $this->createFile($id, $this->request->file('image'));

        return response()->json([
            'success' => true,
            'message' => 'Aplicativo cadastrado com sucesso',
            'id' => $id,
            'image' => $path,
        ]);
    }
    private function createFile($id, $image)
    {
        $fileName = "{$id}.{$image->guessExtension()}";
        $path = $this->request->file('image')
            ->storeAs('imagem-associada', $fileName, 'aplicativos-educacionais');
        $image = new ResizeImage();
        $filePath = $this->storage::disk('aplicativos-educacionais')->url($path);
        $dir = $this->storage::disk('aplicativos-educacionais')->getDriver()->getAdapter()->getPathPrefix() . "imagem-associada/";
        $image->resize($filePath, $fileName, $dir);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aplicativo  $aplicativo
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $validator = Validator::make($this->request->all(), config("rules.aplicativo"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o conteúdo", 201);
        }

        $aplicativo = Aplicativo::find($id);
        $aplicativo->fill($this->request->all());
        //$aplicativo->category_id = $this->request->get('category_id');
        $aplicativo->save();
        // 'options' => json_decode($this->request->get('options', '{}'), true)

        //$this->createFile($aplicativo->id, $this->request->file('image'));

        return $this->successResponse($aplicativo, "salvado com sucesso", 200);
    }
    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response json
     */
    public function delete($id)
    {
        $aplicativo = $this->aplicativo::find($id);
        $resp = [];
        $aplicativo->delete();
        $aplicativo->tags()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Aplicativo deletado com sucesso!!',
        ]);
    }

    public function search(Request $request, $termo)
    {
        $limit = $request->query('limit', 15);
        $page = $request->query('page', 1);
        $search = "%{$termo}%";
        $aplicativos = Aplicativo::select(['id', 'name'])
            ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
            ->paginate($limit);

        $aplicativos->setPath("/aplicativos/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator(
            $aplicativos,
            "resultados da busca pelo termo {$termo}",
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


        if ($aplicativo) {
            return $this->showOne($aplicativo, '', 200);
        } else {
            return $this->errorResponse([], 'Não encontrado', 201);
        }
    }
}
