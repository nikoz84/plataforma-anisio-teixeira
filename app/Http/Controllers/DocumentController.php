<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Document;
use Arcanedev\LogViewer\Contracts\Utilities\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DocumentController extends ApiController
{


    public function __construct()
    {
        $this->middleware('auth:api')->except([
            'getFaculdadesDaBahia',
            'getDocumentByName',
            'getRotinaDeEstudos',
            'rotinasPerNivel',
            'getCanalAT',
            'getPodcastAT'
        ]);
    }
    /**
     * Seleciona e lista a faculdade por id.
     *
     * @return void
     */
    public function getFaculdadesDaBahia()
    {
        $url = "AKfycbyewWsCp5HdbrkQwRSMyeRAsQiRc8PtjeyOrS07drrzxdpjb7HA/exec";

        $doc = new Document();
        $this->createFaculdadesDaBahia($doc->formatarJsonFaculdadesDaBahia(
            $doc->getGoogleSpreadsheetsData($url)
        ));
    }
    /**
     * Cria Aplicativo no Banco de Dados.
     *
     * @param array $dados
     * @return void
     */
    public function createFaculdadesDaBahia($dados)
    {
        foreach ($dados as $dado) {
            $doc = new Document();
            $doc->name = $dado['name'];

            $doc->document = [
                'faculdade' => $dado['faculdade'],
                'slug' => $dado['slug'],
                'actions' => $dado['actions']
            ];

            $doc->save();
        }
    }
    /**
     * Seleciona as Rotinas de Estudos e Lista.
     *
     * @return void
     */
    public function getRotinaDeEstudos()
    {
        $semanas = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];

        foreach ($semanas as $semana) {
            $semana = 'semana-' . $semana;
            $url = "AKfycbzwTW7RUANw0j8CjCIxnWLCQ3QHjiTbCbYapV5frwXyn8UmBdh2/exec?semana={$semana}";

            $documento = new Document();

            $data = $documento->formatarJsonRotinasDeEstudo(
                $documento->getGoogleSpreadsheetsData($url)
            );
            $this->createRotinasDeEstudo($semana, $data);
        }
    }
    /**
     * Salva Rotinas de Estudo no Banco de Dados
     *
     * @param string $semana Nome do documento (ex: semana-1, semana-2)
     * @param array $data Conjunto de dados
     * @return void
     */
    public function createRotinasDeEstudo($semana, $data)
    {
        $doc = new Document();
        $doc->name = $semana;
        $doc->document = $data['rotinas'];
        $doc->save();
    }
    /**
     * Seleciona o documento por nome.
     * @param \Illuminate\Http\Request
     * @param $request string 
     * @return string json
     */

    public function getDocumentByName(Request $request)
    {
        $query = Document::query();
        $url = http_build_query($request->except('page'));

        if ($request->slug === 'rotinas') {
            $doc = $query->where(
                'name',
                'like',
                'semana%'
            )->paginate(10)->setPath("/planilhas?{$url}");
        } else {
            $doc = $query->where('name', $request->slug)
                ->paginate(15)
                ->setPath("/planilhas?{$url}");
        }

        return $this->showAsPaginator($doc);
    }
    /** Testando Rotina por Nível
     * @param mixed $nivel 
     * @param mixed $semana
     * @return string json
     */
    public function rotinasPerNivel($nivel, $semana)
    {
        $query = Document::query();

        $doc = $query->select(
            DB::raw("
                jsonb_array_elements(
                    document->'segunda-feira'->'{$nivel}'
                ) as segunda
                ,
                jsonb_array_elements(
                    document->'terca-feira'->'{$nivel}'
                ) as terca
                ,
                jsonb_array_elements(
                    document->'quarta-feira'->'{$nivel}'
                ) as quarta
                ,
                jsonb_array_elements(
                    document->'quinta-feira'->'{$nivel}'
                ) as quinta
                ,
                jsonb_array_elements(
                    document->'sexta-feira'->'{$nivel}'
                ) as sexta")
        )->where(
            'name',
            'like',
            $semana
        )->get();



        return $this->successResponse([
            'rotinas' => $doc,
            'semanas' => $this->getSemanas()
        ]);
    }
    /**
     * Seleciona por semana.
     *
     * @return void
     */
    public function getSemanas()
    {
        $total = Document::where('name', 'like', 'semana%')->get();

        $semanas = [];
        for ($i = 1; $i <= $total->count(); $i++) {
            array_push($semanas, [
                'value' => "semana-{$i}",
                'label' => "Semana {$i}"
            ]);
        }

        return $semanas;
    }
    /**
     *  Lista conteudo do Canal AT
     *  @return string json
     */
    public function getCanalAT()
    {
        return $this->showOne(
            Document::where('name', 'canal-anisio-teixeira')->get()->first()
        );
    }
    /**
     *  Lista conteudo do Podcast AT
     *  @return string json
     */
    public function getPodcastAT()
    {
        $path = Storage::disk('podcast-at');

        $path = $path->getDriver()->getAdapter()->getPathPrefix();

        $files = File::allFiles($path);

        $podcasts = collect($files)->map(function ($file) {
            return [
                'name' => pathinfo($file->getFilename(), PATHINFO_FILENAME),
                'src' => Storage::disk('podcast-at')->url("{$file->getFilename()}"),
                'type' => 'audio/mp3'
            ];
        })->shuffle();

        return $this->showAll($podcasts);
    }
}
