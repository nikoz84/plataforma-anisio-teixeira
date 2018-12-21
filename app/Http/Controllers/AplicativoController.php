<?php

namespace App\Http\Controllers;

use App\Aplicativo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\UrlValidator;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ResizeImage;

class AplicativoController extends Controller
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
        $limit = ($request->has('limit')) ? $request->query('limit') : 15;
        $page = ($request->has('page')) ? $request->query('page') : 1;

        $aplicativos = Aplicativo::with(['category', 'canal'])
                                    //->select(['id','user_id','name'])
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        $aplicativos->setPath("/aplicativos?limit={$limit}");

        return response()->json([
            'success' => true,
            'title' => 'Aplicativos Educacionais',
            'paginator' => $aplicativos
        ]);
    }

    /**
     * Valida a criação do Aplicativo
     *
     * @return
     */
    private function validar()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|min:2|max:255',
            'description' => 'required|min:140',
            'url' => ['required', new UrlValidator],
            'category_id' => 'required',
            'tags' => 'required',
            'image' => 'required',
            'is_featured' => 'required'
        ]);

        return $validator;
    }

    /**
     * Cria um novo aplicativo.
     *
     *
     */
    public function create()
    {
        $validator = $this->validar($this->request);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível efetuar o cadastro',
                'errors' => $validator->errors()
            ], 200);
        }

        $aplicativo = $this->aplicativo;

        $aplicativo->user_id = Auth::user()->id;
        $aplicativo->category_id = $this->request->get('category_id');
        $aplicativo->canal_id = $this->request->get('canal_id', 9);
        $aplicativo->name = $this->request->get('name');
        $aplicativo->url = $this->request->get('url');
        $aplicativo->description = $this->request->get('description');
        $aplicativo->is_featured = $this->request->get('is_featured');
        $aplicativo->options = json_decode($this->request->get('options', '{}'), true);
        //$aplicativo->tags->attach($this->request->get('tags'));
        $aplicativo->save();

        $path = $this->createFile($aplicativo->id, $this->request->file('image'));

        return response()->json([
            'success' => true,
            'message' => 'Aplicativo cadastrado com sucesso',
            'id' => $aplicativo->id,
            'image' => $path
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
        
        $aplicativo = Aplicativo::find($id);
        $aplicativo->fill($this->request->all());
        //$aplicativo->category_id = $this->request->get('category_id');
        $aplicativo->save();
        // 'options' => json_decode($this->request->get('options', '{}'), true)

        //$this->createFile($aplicativo->id, $this->request->file('image'));

        return response()->json([
                'success' => true,
                'aplicativo'=> $aplicativo
            ]);
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
            'message' => 'Aplicativo deletado com sucesso!!'
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

        return response()->json([
            'success' => true,
            'message' => 'Resultados da busca',
            'paginator' => $aplicativos
        ]);
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
            return response()->json([
                'success' => true,
                'aplicativo' => $aplicativo,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'aplicativo' => 'Não encontrado'
            ]);
        }
    }
}
