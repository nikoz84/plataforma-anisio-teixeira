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
     * @return Model $mode
     */
    static function getById(Builder $query, $id)
    {
        $value = Cache::remember($query->getModel()->getTable().$id, 302, function () use ($query, $id)
        {   
            return $query->findOrFail($id);
        });
        return $value;

    }

    static function search(Builder $query, string $search, $limit)
    {
        $value = Cache::remember( $query->getModel()->getTable().$search.$limit , 302, function () use ($query, $limit)
        { 
            return $query->paginate($limit);
        });
        return $value;
    }

    static function getAll(Builder $query, $url, $limit = 6)
    {
        $value = Cache::remember( "all".$query->getModel()->getTable().$limit , 302, function () use ($query, $url, $limit)
        { 
            return $query->paginate($limit)->setPath($url);
        });
        return $value;
    }
}