<?php

namespace App\Http\Controllers;

use App\Helpers\WordpressService;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class WordpressController extends ApiController
{
    public function __construct(Storage $storage, Request $request)
    {
        $this->middleware('jwt.verify')->except(['index', 'search', 'getById', 'getEstatisticas']);
        $this->storage = $storage;
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wordpress = new WordpressService($this->request);

        return $this->showAsPaginator($wordpress->getPosts());
    }

    public function search($termo)
    {
        $limit = $this->request->query('limit', 6);
        $page = $this->request->query('page', 1);
        $search = "%{$termo}%";
    }
    /**
     * Seleciona um recurso por id
     *
     * @param Integer $id
     * @return json
     */
    public function getById()
    {
        $wordpress = new WordpressService($this->request);

        return $this->successResponse($wordpress->getOne(), "", 200);
    }

    public function getEstatisticas()
    {
        $wordpress = new WordpressService($this->request);

        $wordpress->getCatalogacao();
    }
}
