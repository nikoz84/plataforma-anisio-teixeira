<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;

trait ToPaginator
{
    public function getPaginator(Collection $collect, $limit, $page, $total, $path)
    {
        if (! $collect instanceof Collection) {
            $collect = collect($collect);
        }
        $paginator = new Paginator($collect, $total, $limit, $page, ['oi' => 'kd']);
        $paginator->setPath($path."?limit=$limit");

        return $paginator;
    }
}
