<?php

namespace App\Helpers;

use App\Canal;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Traits\FileSystemLogic;

class WordpressService
{
    use FileSystemLogic;

    protected $api;
    protected $slug;
    protected $id_canal;
    protected $limit;
    protected $post;

    public function __construct($limit = 15, $page = 1)
    {
        $canal = $canal = Canal::find(7);
        $canal_url = $canal->options['back_url'];
        $this->limit = $limit;
        $this->page = $page;
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
        //$paginatedItems::resolveCurrentPage($this->page);
        $paginatedItems->setPath("/conteudos?canal=7&limit={$this->limit}");

        return $paginatedItems;
    }
}
