<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;

class ApiController extends Controller
{
    /**
     * Trait de respostas com métodos comuns para todos os controladores filhos
     */
    use ApiResponser;
    /**
     * Todo o javascript vai se renderizar em essa view
     *
     * @return void
     */
    public function home()
    {
        return view('index');
    }

    /**
     * retorna mensagens de validações padrão para os formulários em geral
     * @return array conjunto de mensagens para as validações dos formulários em geral
     */
    protected function messagesRules(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => "O número mínimo de caracteres para este campo é :min",
            'max' => "O número máximo de caracteres para este campo é de :max",
            'mimes' => "Formato do arquivo é incorreto"
        ];
    }
}
