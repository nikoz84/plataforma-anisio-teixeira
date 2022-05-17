<?php

namespace App\Http\Controllers;

use App\Services\WordpressService;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
use App\Models\Wordpress\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WordpressController extends ApiController
{
    public function __construct(Storage $storage, Request $request)
    {
        $this->middleware('jwt.auth')->except(['index', 'search', 'getById', 'getEstatisticas']);
        $this->storage = $storage;
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     * Exibe uma lista de recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$wordpress = new WordpressService($this->request);

        //return $this->showAsPaginator($wordpress->getPosts());
        $search = Post::query();
        if (request('term')) {
            $term = "%{request('term')}%";
            $search->where('post_type', '=', 'post')
            ->where('post_status', '=', 'publish')
            ->whereRaw("post_title like ?", [$term]);
        }
        $paginator = $search->orderBy('post_date', 'DESC')->paginate(10);
        return $this->showAsPaginator($paginator);
    }
    
    /**
     * Select a resource by id.
     * Seleciona um recurso por id.
     *
     * @param Integer $id
     * @return json
     */
    public function getById()
    {
        $wordpress = new WordpressService($this->request);

        return $this->successResponse($wordpress->getOne(), "", 200);
    }
    /**
     * Method that selects id by statistics.
     * Método que seleciona o id por estatistica 
     * 
     * @return void
     */
    public function getEstatisticas()
    {
        $wordpress = new WordpressService($this->request);

        $wordpress->getCatalogacao();
    }

    public function search($term)
    {
        $search = Post::query();
        if (request('term')) {
            $term = "%{$term}%";
            $search->where('post_type', '=', 'post')
            ->where('post_status', '=', 'publish')
            ->whereRaw("post_title like ?", [$term]);
        }
        
        return $search->orderBy('post_date', 'DESC')->paginate(10);
    }
}
