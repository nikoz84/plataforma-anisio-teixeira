<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

trait ApiResponser
{
    /**
     * Estrutura padrão de retorno para respostas com sucesso
     * 
     * @param mixed $data Recebe um array ou coleção de dados
     * @param string $message Recebe uma mensagem opcional
     * @param integer $code Código HTTP ou statusCode
     * 
     * @return string json
     */
    protected function successResponse($data, $message = '', $code = 200)
    {
        return response()->json([
            'metadata' => $data,
            'message' => $message,
            'success' => true
        ], $code);
    }

    /**
     * Estrutura padrão de retorno para erros
     * 
     * @param mixed $errors Erros da aplicação
     * @param string $message Mensagem alternativa
     * @param integer $code Código HTTP ou statusCode
     * @param mixed $headers Cabeçalhos HTTP
     * 
     * @return string json
     */
    protected function errorResponse($errors, $message, $code, $headers = null)
    {
        if ($headers) {
            return response()->json([
                'errors' => $errors,
                'message' => $message,
                'success' => false
            ], $code, $headers);
        } else {
            return response()->json([
                'errors' => $errors,
                'message' => $message,
                'success' => false
            ], $code);
        }
    }
    /**
     * Resposta de uma coleção de dados 
     * 
     * @param \Illuminate\Support\Collection $collection Recebe uma coleção laravel
     * @param string $message Mensagem alternativa
     * @param integer $code Código HTTP ou statusCode
     * 
     * @return string json
     */
    protected function showAll(Collection $collection, $message = '', $code = 200)
    {
        return $this->successResponse($collection, $message, $code);
    }

    /**
     * Resposta em formato paginação
     * 
     * @param Paginator $paginator Recebe um objeto de tipo paginator
     * @param string $message Recebe uma mensagem opcional
     * @param integer $code Código HTTP ou statusCode
     * 
     * @return string json
     */
    protected function showAsPaginator(Paginator $paginator, $message = '', $code = 200)
    {
        return response()->json([
            'paginator' => $paginator,
            'message' => $message,
            'success' => true
        ], $code);
    }

    /**
     * Resposta json da um modelo
     * 
     * @param Model $instance Instância de um modelo
     * @param string $message Mensagem opcional
     * @param integer $code Código HTTP ou statusCode
     * 
     * @return string json
     */

    protected function showOne(Model $instance, $message = '', $code = 200)
    {
        return $this->successResponse($instance, $message, $code);
    }

    /**
     * Transforma coleção para um select com chave valor id => name
     * @param Collection $collection Coleção laravel
     * 
     * @return string json
     */
    protected function fetchForSelect(Collection $collection)
    {
        $select = $collection->map(function ($item) {
            $data['name'] = $item->name ? $item->name : $item->title;
            $data['id'] = $item->id;
            return $data;
        });
        return $this->showAll($select);
    }
}
