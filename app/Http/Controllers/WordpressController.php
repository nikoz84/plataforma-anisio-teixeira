<?php

namespace App\Http\Controllers;

use App\Services\WordpressService;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
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
        $wordpress = new WordpressService($this->request);


        return $this->showAsPaginator($wordpress->getPosts());
    }
    /**
     *  Search Database Information.
     *  Busca informações do Banco de Dados.
     *
     * @param string $termo identificador único
     * @param \App\Wordpress $wordpress
     * @return \App\Controller\ApiResponser 
     * retorna Json
     */
    public function search($termo)
    {
        $limit = $this->request->query('limit', 6);
        $page = $this->request->query('page', 1);
        $search = "%{$termo}%";
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
}
