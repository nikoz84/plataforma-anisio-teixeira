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

    public function index()
    {
        
        $playlist = PlayList::where('name', 'pl-%');

        $this->authorize('index', $playlist);

        return $this->successResponse($playlist);
    }

    public function create(PlaylistRequest $request)
    {
        $playlist = new PlayList();

        $this->authorize('create', $playlist);
        
        $playlist->fill($request->validated());

        if($playlist->save()){
            return $this->successResponse([], 'Playlist adicionada com succeso!');
        }

    }

    public function search(Request $request, $term)
    {
        $limit = $request->query('limit', 8);
        $term  = Str::lower($term);

        $paginator = Conteudo::with(['tipo'])->where('title', "ilike", "%{$term}%")
            ->paginate($limit);

        $paginator->getCollection()->transform(function($item) use ($term) {
            $replace = preg_replace('/(' . $term . ')/i', "<b>$1</b> ", Str::lower($item->title));
            $item->title = "<p>" . Str::replace('B>', 'b>', Str::title($replace)) . "</p>";
            return $item;
        });

        return $this->showAsPaginator($paginator);
    }
    
    public static function toPaginator($data)
    {
        $items = collect($data);


    }

    public function addToPlayList($id)
    {
        $playlist = PlayList::findOrFail($id);

        $conteudos = collect($playlist->ids);
        //$this->authorize('index','$addToPlaylist');

        return $this->successResponse($playlist);
    }

    public function removeToPlayList($id)
    {
        $remove = $this->Playlist->findOrFail($id);
            $remove->delete();

            return $this->successResponse($remove);
    }

    public function updatePlayList(PlaylistRequest $request, $id)
    {
       $playlist = PlayList::findOrFail($id);

       $playlist->fill($request->validated());

       
       return response()->json($playlist);
    }

    public function getByName(Request $request)
    {
        $name = PlayList::where('name', "pl-%{$request->name}");

        return $this->successResponse($name);
    }
    public function getById($id)
    {
        $playlist = PlayList::findOrFail($id);

        //$this->authorize('index', $getById);

        return $this->successResponse($playlist);
    }
}