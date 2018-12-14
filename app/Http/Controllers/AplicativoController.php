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
        $this->middleware('jwt.verify')->except(['list','search','getById']);
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

        $aplicativos = Aplicativo::with(['category','canal'])
                                    //->select(['id','user_id','name'])
                                    ->orderBy('created_at', 'desc')
                                    ->paginate($limit);
        
        $aplicativos->setPath("/aplicativos?limit={$limit}");

        return response()->json([
            'success'=> true,
            'title'=> 'Aplicativos Educacionais',
            'paginator'=> $aplicativos
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
            'category' => 'required',
            'tags' => 'required',
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
        $aplicativo->category_id = $this->request->get('category', '');
        $aplicativo->canal_id = $this->request->get('canal', 9);
        $aplicativo->name = $this->request->get('name', '');
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
        $file_name = "{$id}.{$image->guessExtension()}";
        $path = $this->request->file('image')
                            ->storeAs('imagem-associada', $file_name, 'aplicativos-educacionais');
        $image = new ResizeImage();

        return $image->resize($this->storage::disk('aplicativos-educacionais')->files($path));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aplicativo  $aplicativo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $aplicativo = Aplicativo::find($id);

        $data = [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'is_featured' => $request->get('is_featured'),
            'options' => $request->get('options')
        ];

        $aplicativo->save($data);

        return response()->json($aplicativo->toJson());
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aplicativo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $aplicativo = Aplicativo::find($id);
        $resp = [];
        if (is_null($aplicativo)) {
            $resp = [
                'menssage' => 'Aplicativo não encontrado',
                'is_deleted' => false
            ];
        } else {
            $resp = [
                'menssage' => "Aplicativo de id: {$id} foi apagado com sucesso!!",
                'is_deleted' => $aplicativo->delete()
            ];
        }
        
        return response()->json($resp);
    }

    public function search(Request $request, $termo)
    {
        $limit = $request->query('limit', 15);
        $page = $request->query('page', 1);
        $search= "%{$termo}%";
        $aplicativos = Aplicativo::select(['id','name'])
                                ->whereRaw('unaccent(lower(name)) LIKE unaccent(lower(?))', [$search])
                                ->paginate($limit);

        $aplicativos->setPath("/aplicativos/search/{$termo}?limit={$limit}");

        return response()->json([
            'success'=> true,
            'message' => 'Resultados da busca',
            'paginator' => $aplicativos,
            'page'=> $aplicativos->currentPage(),
            'limit' => $aplicativos->perPage()
        ]);
    }
    public function getById(Request $request, $id)
    {
        $aplicativo = Aplicativo::with(['tags','category','user','canal'])
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
