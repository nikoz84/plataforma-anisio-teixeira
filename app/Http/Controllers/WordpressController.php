<?php

namespace App\Http\Controllers;

use App\Helpers\WordpressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;

class WordpressController extends ApiController
{
    public function __construct(Request $request, Storage $storage)
    {
        $this->middleware('jwt.verify')->except(['index', 'search', 'getById', 'getEstatisticas']);
        $this->request = $request;
        $this->storage = $storage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wordpress = new WordpressService($this->request);

        return $this->showAsPaginator($wordpress->getPosts(), 'Conteúdos blog', 200);
    }

    public function getOne($id)
    {
        $wordpress = new WordpressService($this->request);

        return $this->successResponse($wordpress->getOne($id), "Postagem", 200);
    }





    public function search(Request $request, $termo)
    {
        $limit = $request->query('limit', 15);
        $page = $request->query('page', 1);
        $search = "%{$termo}%";
    }
    /**
     * Seleciona um recurso por id
     *
     * @param Integer $id
     * @return json
     */
    public function getById($id)
    {
        //
    }

    public function getEstatisticas()
    {
        $wordpress = new WordpressService($this->request);

        $wordpress->getCatalogacao();
    }
}
