<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use App\Services\SearchEngineOptimization;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
class ApiController extends Controller
{
    

    public function __construct(Request $request, CrawlerDetect $crawlerDetect)
    {
        $this->seo = new SearchEngineOptimization($request);
        $this->crawlerDetect = $crawlerDetect;
    }
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
        $data = $this->seo->getDefaultData();

        if($this->crawlerDetect->isCrawler()){
            $data = $this->seo->getMetadata();
        }
        return view('index', $data);
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
