<?php

namespace App\Http\Controllers;

use App\Services\WordpressService;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
use App\Models\Wordpress\Post;
use App\Models\Wordpress\Term;
use Illuminate\Http\Request;

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
        $term = $this->request->input('term', '');
        $post = Post::query();
        //$post->select(['ID', 'post_title', 'post_type', 'post_status', 'post_excerpt', 'post_date']);
        if ($term) {
            $term = "%{$term}%";
            $post->whereRaw("post_title like ?", [$term]);
        }
        $post->where('post_type', '=', 'post')
            ->where('post_status', '=', 'publish');
        $post->with(['user']);
        $paginator = $post->orderBy('post_date', 'DESC')->paginate(10);
        return $this->showAsPaginator($paginator);
    }

    /**
     * Select a resource by id.
     * Seleciona um recurso por id.
     *
     * @param Integer $id
     * @return json
     */
    public function getById($id)
    {
        $post = Post::findOrFail($id);

    
        
        return $this->successResponse($post);
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
