<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Models\PlayList;
use Illuminate\Http\Request;
use App\Http\Requests\PlaylistRequest;
use App\Models\Conteudo;
use Illuminate\Support\Str;
use App\Traits\ToPaginator;

class PlayListController extends ApiController
{
    use ToPaginator;

    /**
     * Método que lista a playlist
     */

    public function index()
    {

        $playlist = PlayList::where('name', 'pl-%');

        $this->authorize('index', $playlist);

        return $this->successResponse($playlist);
    }
    /**
     * Método que cria a PlayList
     * @param App\Http\Requests\PlaylistRequest
     * @return string - Json
     */
    public function create(PlaylistRequest $request)
    {

        $playlist = new PlayList();

        //dd($request->all());
         
        $this->authorize('create', $playlist);

       $playlist->fill($request->validated());
         
        $request->validated();

        if ($playlist->save()) {
            return $this->successResponse([], 'Playlist adicionada com succeso!');
        }
    }
    /**
     * Método que busca por termo
     * @param App\Http\Request
     * @param App\http\Request $request
     * @param mixed $termo 
     * 
     * @return String - Json
     */
    public function search(Request $request, $term)
    {
        $limit = $request->query('limit', 8);
        $term  = Str::lower($term);

        $paginator = Conteudo::with(['tipo'])->where('title', "ilike", "%{$term}%")
            ->paginate($limit);

        $paginator->getCollection()->transform(function ($item) use ($term) {
            $replace = preg_replace('/(' . $term . ')/i', "<b>$1</b> ", Str::lower($item->title));
            $item->title = "<p>" . Str::replace('B>', 'b>', Str::title($replace)) . "</p>";
            return $item;
        });

        return $this->showAsPaginator($paginator);
    }
    /**
     * Método Estático para paginar
     * @param mixed $data
     * @return void
     */
    public static function toPaginator($data)
    {
        $items = collect($data);
    }
    /**
     * Método adiciona a Playlist por id
     * @param integer id identificador único $id
     * @return string json
     */
    public function addToPlayList($id)
    {
        $playlist = PlayList::findOrFail($id);

        $conteudos = collect($playlist->ids);
        //$this->authorize('index','$addToPlaylist');

        return $this->successResponse($playlist);
    }

    /**
     * Método que remove da playlist por id
     * @param integer id identificador único $id
     * @return string - json
     */

    public function removeToPlayList($id)
    {
        $remove = $this->Playlist->findOrFail($id);
        $remove->delete();

        return $this->successResponse($remove);
    }
    /**
     * Método que atualiza a playlist
     * @param App\Http\Request\PlalylistRequest $request
     * @param integer id identificador único
     * @return string json
     */

    public function updatePlayList(PlaylistRequest $request, $id)
    {
        $playlist = PlayList::findOrFail($id);
        $playlist->fill($request->validated());


        return response()->json($playlist);
    }
    /**
     * Adiciona na lista por nome 
     * @param Illuminate\Http\Request
     * @return string - json
     */
    public function getByName(Request $request)
    {
        $name = PlayList::where('name', "pl-%{$request->name}");

        return $this->successResponse($name);
    }
    /**
     * Adiciona na playlity por id
     * @param integer id identificador único $id
     * @return string - json
     */
    public function getById($id)
    {
        $playlist = PlayList::findOrFail($id);

        //$this->authorize('index', $getById);

        return $this->successResponse($playlist);
    }
}
