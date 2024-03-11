<?php

namespace App\Http\Controllers;

use App\Services\SearchEngineOptimization;
use App\Traits\ApiResponser;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Illuminate\Support\Facades\Config;

class ApiController extends Controller
{
    /**
     * Trait de respostas com métodos comuns para todos os controladores filhos
     */
    use ApiResponser;
    private $seo;

    private $crawlerDetect;

    private $request;

    public function __construct(Request $request, CrawlerDetect $crawlerDetect)
    {
        //$this->seo = new SearchEngineOptimization($request);
        $this->crawlerDetect = $crawlerDetect;
        $this->request = $request;
    }

    /**
     * Todo o javascript vai se renderizar  nessa view
     *
     * @return void
     */
    public function home()
    {
       // $data = $this->seo->getDefaultData();
        //$crawler = 'Mozilla/5.0 (compatible; aiHitBot/2.9; +https://www.aihitdata.com/about)';

        // if ($this->crawlerDetect->isCrawler()) {
        //     $data = $this->seo->getMetadata();

        //     $url = $this->request::fullUrl();
        // }
        $data = [
            'title' => Config::get('seo.title'),
            'author' => Config::get('seo.author'),
            'url' => $this->request::fullUrl(),
            'description' => Config::get('seo.description'),
            'keywords' => Config::get('seo.keywords'),
            'canonical' => Config::get('seo.canonical'),
            'locale' => Config::get('seo.locale'),
            'sitename' => Config::get('seo.sitename'),
        ];;

        return view('index', $data);
    }

    /**
     * retorna mensagens de validações padrão para os formulários em geral
     *
     * @return array conjunto de mensagens para as validações dos formulários em geral
     */
    protected function messagesRules()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O número mínimo de caracteres para este campo é :min',
            'max' => 'O número máximo de caracteres para este campo é de :max',
            'mimes' => 'Formato do arquivo é incorreto',
        ];
    }
}
