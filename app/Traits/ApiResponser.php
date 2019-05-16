<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Http\Response;

trait ApiResponser
{
    protected function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($data, $code)
    {
        return response()->json([$data], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successResponse($collection, $code);
    }
    protected function showAsPaginator(Paginator $paginator, $code = 200)
    {
        return $this->successResponse(['paginator' => $paginator], $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse($instance, $code);
    }
}