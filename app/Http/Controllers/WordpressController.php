<?php

namespace App\Http\Controllers;

use App\Services\WordpressService;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
use App\Models\Wordpress\Post;
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
        $search = Post::query();
        $search->with(['user']);
        if ($term) {
            $term = "%{$term}%";
            $search->whereRaw("post_title like ?", [$term]);
        }
        $search->where('post_type', '=', 'post')
            ->where('post_status', '=', 'publish');
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
    public function getById($id)
    {
        $post = Post::with(['user'])->findOrFail($id);

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
