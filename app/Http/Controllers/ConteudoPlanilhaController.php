<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\ConteudoPlanilha;
use Illuminate\Support\Facades\DB;

class ConteudoPlanilhaController extends ApiController
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

    public function getFaculdadesDaBahia()
    {
        $url = "AKfycbyewWsCp5HdbrkQwRSMyeRAsQiRc8PtjeyOrS07drrzxdpjb7HA/exec";

        $conteudoPlanilha = new ConteudoPlanilha();
        $this->createFaculdadesDaBahia($conteudoPlanilha->formatarJsonFaculdadesDaBahia(
            $conteudoPlanilha->getGoogleSpreadsheetsData($url)
        ));
    }

    public function createFaculdadesDaBahia($dados)
    {
        foreach ($dados as $dado) {
            $conteudoPlanilha = new ConteudoPlanilha();
            $conteudoPlanilha->name = $dado['name'];
            
            $conteudoPlanilha->document = [
                'faculdade' => $dado['faculdade'],
                'slug' => $dado['slug'],
                'actions' => $dado['actions']];

            $conteudoPlanilha->save();
        }
    }
    public function getRotinaDeEstudos()
    {
        $semanas = [1,2,3,4,5,6,7,8,9,10,11,12,13,14];
        
        foreach ($semanas as $semana) {
            $semana = 'semana-' . $semana;
            $url = "AKfycbzwTW7RUANw0j8CjCIxnWLCQ3QHjiTbCbYapV5frwXyn8UmBdh2/exec?semana={$semana}";
            
            $documento = new ConteudoPlanilha();
            
            $data = $documento->formatarJsonRotinasDeEstudo(
                $documento->getGoogleSpreadsheetsData($url)
            );

            $this->createRotinasDeEstudo($semana, $data);
        }
    }

    public function createRotinasDeEstudo($semana, $data)
    {
        $conteudoPlanilha = new ConteudoPlanilha();
        
        $conteudoPlanilha->name = $semana;
        $conteudoPlanilha->document = $data['rotinas'];
        
        $conteudoPlanilha->save();
    }

    public function getDocumentByName(Request $request)
    {
        $query = ConteudoPlanilha::query();
        $url = http_build_query($request->except('page'));

        if ($request->slug === 'rotinas') {
            $conteudoPlanilha = $query->where(
                'name',
                'like',
                'semana%'
            )->paginate(10)->setPath("/planilhas?{$url}");
        } else {
            $conteudoPlanilha = $query->where('name', $request->slug)
            ->paginate(10)
            ->setPath("/planilhas?{$url}");
        }

        return $this->showAsPaginator($conteudoPlanilha);
    }
    /** teste */
    public function rotinasPerNivel(Request $request, $nivel, $semana)
    {
        $query = ConteudoPlanilha::query();
        
        $conteudoPlanilha = $query->select(
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
            'rotinas' => $conteudoPlanilha,
            'semanas' => $this->getSemanas()
        ]);
    }

    public function getSemanas()
    {
        $total = ConteudoPlanilha::where('name', 'like', 'semana%')->get();
        
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
