<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

trait ApiResponser
{
    protected function successResponse($data, $message, $code)
    {
        return response()->json([
            'metadata' => $data,
            'message' => $message,
            'success' => true
        ], $code);
    }

    protected function errorResponse($errors, $message, $code)
    {
        return response()->json([
            'errors'=> $errors,
            'message' => $message,
            'success' => false
        ], $code);
    }

    protected function showAll(Collection $collection, $message = '', $code = 200)
    {
        return $this->successResponse($collection, $message, $code);
    }
    protected function showAsPaginator(Paginator $paginator, $message = '', $code = 200)
    {
        return response()->json([
            'paginator' => $paginator,
            'message' => $message,
            'success' => true
        ], $code);
    }

    protected function showOne(Model $instance, $message = '', $code = 200)
    {
        return $this->successResponse($instance, $message, $code);
    }
    
}