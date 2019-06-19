<?php

namespace App\Helpers;

use App\Canal;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Traits\FileSystemLogic;
use Illuminate\Http\Request;

class WordpressService
{
    use FileSystemLogic;

    protected $api;
    protected $slug;
    protected $id_canal;
    protected $limit;
    protected $post;
    protected $data_inicio;
    protected $data_fim;

    public function __construct(Request $request)
    {
        $this->limit = $request->query('limit', 15);
        $this->page = $request->query('page', 1);
        $this->id = $request->query('id', 0);
        $this->data_inicio = $request->query('inicio', date('Y-01-01 00:00:00'));
        $this->data_fim = $request->query('fim', date("Y-m-d H:i:s"));

        $canal = $canal = Canal::find(7);
        $canal_url = $canal->options['back_url'];

        $this->api =  $canal_url . "/wp-json/pat/v1/";
    }

    public function getPosts()
    {
        $url = $this->api . "posts";

        $response = Curl::to($url)
            ->withData([
                'limit' => $this->limit,
                'page' => $this->page
            ])->asJsonResponse()
            ->get();

        if ($response) {
            return $this->getPaginator($response);
        }
    }

    protected function getPaginator($data)
    {

        $itemsCollection = collect($data->posts);
        $paginatedItems = new Paginator($itemsCollection, $data->total, $this->limit, $this->page);

        $paginatedItems->setPath("/posts?limit={$this->limit}");

        return $paginatedItems;
    }

    public function getCatalogacao()
    {
        $url = $this->api . "posts/catalogacao";
        $data = [
            'inicio' => $this->data_inicio,
            'fim'    => $this->data_fim
        ];
        $response = Curl::to($url)
            //->withData($data)
            ->asJsonResponse()
            ->get();

        return $response;
    }

    public function getOne()
    {
        $url = $this->api . "posts/{$this->id}";

        $response = Curl::to($url)
            ->asJsonResponse()
            ->get();

        return $response;
    }
}
