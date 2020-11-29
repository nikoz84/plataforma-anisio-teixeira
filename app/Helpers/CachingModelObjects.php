<?php

namespace App\Helpers;

use App\Conteudo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CachingModelObjects
{
    private $minutes = 640;

    /**
     * recupera um objeto do cache ou atualiza cache com um objeto do banco de dados
     * @return Model $model
     */
    static function getById(Builder $query, $id)
    {
        $cacheKey = $query->getModel()->getTable().$id;
        $value = Cache::remember($cacheKey, 1024, function () use ($query, $id)
        {   
            return $query->findOrFail($id);
        });
        return $value;
    }

    static function search(Builder $query, string $search, $limit)
    {
        $cacheKey = $query->getModel()->getTable().$search.$limit;
        $value = Cache::remember( $cacheKey  , 1024, function () use ($query, $limit)
        { 
            return $query->paginate($limit);
        });
        return $value;
    }
}