<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

trait ToPaginator
{

    public function getPaginator(Collection $collect, $limit = 8, $page = 1, $total, $path)
    {
        if(!$collect instanceof Collection){
            $collect = collect($collect);
        }
        $paginator = new Paginator($collect, $total, $limit, $page, ['oi' => 'kd']);
        $paginator->setPath($path . "?limit=$limit");
        return $paginator;
    }
}