<?php

namespace App\Services;

use App\Models\Canal;
use App\Traits\FileSystemLogic;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

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

    protected $timeout;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->timeout = 10.0;
        $this->limit = $request->query('limit', 6);
        $this->page = $request->query('page', 1);
        $this->data_inicio = $request->query('inicio', date('Y-01-01 00:00:00'));
        $this->data_fim = $request->query('fim', Carbon::now());

        $canal = Canal::find(7);

        $this->api = $canal->options['back_url'].'/wp-json/pat/v1/';
    }

    public function getPosts()
    {
        $client = new Client([
            'base_uri' => $this->api,
            'timeout' => $this->timeout,
            'query' => ['page' => $this->page, 'limit' => $this->limit],
        ]);

        $response = $client->request('GET', 'posts');
        $data = json_decode($response->getBody(), true);

        return $this->getPaginator($data);
    }

    protected function getPaginator($data)
    {
        $itemsCollection = collect($data);

        $total = $itemsCollection->get('total');
        $items = $itemsCollection->get('posts');

        $paginatedItems = new Paginator($items, $total, $this->limit, null);

        $paginatedItems->setPath("/posts?limit={$this->limit}");

        return $paginatedItems;
    }

    public function getCatalogacao()
    {
        $client = new Client([
            'base_uri' => $this->api,
            'timeout' => $this->timeout,
            'query' => [
                'inicio' => $this->data_inicio,
                'fim' => $this->data_fim,
            ],
        ]);

        $response = $client->request('GET', 'posts');

        return json_decode($response->getBody(), true);
    }

    public function getOne()
    {
        $client = new Client([
            'base_uri' => $this->api,
            'timeout' => $this->timeout,
        ]);

        $response = $client->request('GET', "posts/{$this->request->id}");

        return json_decode($response->getBody(), true);
    }
}
