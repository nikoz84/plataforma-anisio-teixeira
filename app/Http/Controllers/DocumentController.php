<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\DB;

class DocumentController extends ApiController
{ 
    

    public function __construct(Request $request)
    {
        $this->middleware('auth:api')->except([
            'getFaculdadesDaBahia',
            'getDocumentByName',
            'getRotinaDeEstudos',
            'rotinasPerNivel'
        ]);
        $request = $request;
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
       * @param [type] $dados
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
                'actions' => $dado['actions']];

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
        $semanas = [1,2,3,4,5,6,7,8,9,10,11,12,13,14];
        
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
      * Cria Rotinas de Estudo do Aplicativo no Banco de Dados
      *
      * @param [type] $semana
      * @param [type] $data
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
     * Seleciona e requisita a Resposta por nome no Banco de Dados.
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
    /** teste */
    public function rotinasPerNivel(Request $request, $nivel, $semana)
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
        for ($i=1; $i <= $total->count(); $i++) {
            array_push($semanas, [
                'value' => "semana-{$i}",
                'label' => "Semana {$i}"
            ]);
        }

        return $semanas;
    }
}
