<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Models\PlayList;
use Illuminate\Http\Request;
use App\Http\Requests\PlaylistRequest;
use App\Models\Conteudo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlayListController extends ApiController
{
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

    public function search($term)
    {
        $conteudos = Conteudo::where('title', "ilike", "%{$term}%")->limit(20)->get();

        return $this->successResponse($conteudos);
    }
    

    public function addToPlayList()
    {
        $addToPlaylist = PlayList::where('name','p1-%');
        $this->authorize('index','$addToPlaylist');

        return $this->successResponse($addToPlaylist);
    }

    public function removeToPlayList($id)
    {
        $remove = $this->Playlist->findOrFail($id);
            $remove->delete();

            return $this->successResponse($remove);
    }

    public function updatePlayList( PlaylistRequest $request)
    {
       $data = $request->all();

       $playlist->fill($request->validated());

       $playlist = $this->playlist->find($data['id']);
       $playlist->update($data);

       return response()->json($playlist);
    }

    public function getByName()
    {
         $getByName = PlayList::where('name', 'pl-%');

        $this->authorize('index', $getByName);

        return $this->successResponse($getByName);
    }
    public function getById()
    {
         $getById = PlayList::where('id', 'pl-%');

        $this->authorize('index', $getById);

        return $this->successResponse($getById);
    }
}