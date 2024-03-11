<?php

namespace App\Console\Commands;

use App\Models\Conteudo;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TesteChunk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teste:chunk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*
        $conteudos = Conteudo::all();
        $count = 0;
        $conteudos->chunk(100)->map(function($chunk) use (&$count){
            $chunk->map(function($conteudo){
                $this->line("{$conteudo->id}");
            });
            Log::debug(count($chunk));
            $count = $count + count($chunk);
        });
        Log::debug($count);
        */
        $ano = '2018';
        $conteudo = new Conteudo;
        $totalizar = 0;
        $conteudos = $conteudo->conteudosPorAno($ano);
        $conteudos->chunk(100)->map(function ($chunk) use (&$totalizar, &$ano) {
            Log::debug(count($chunk));
            $flag = 'baixados';
            $total = count($chunk);
            $title = "Conteúdos publicados no ano de $ano";
            $totalizar = $totalizar + count($chunk);
            $conteudos = $chunk;
            PDF::loadView(
                'relatorios.pdf-conteudo',
                compact('conteudos', 'title', 'flag', 'totalizar', 'total')
            )->setPaper('a4')
            ->stream("{$totalizar}.relatório_conteúdos.pdf");
        });
        Log::alert($totalizar);
        //return PDF::loadView('relatorios.pdf-conteudo', compact('conteudos', 'title', 'flag', 'totalizar', 'total'))->setPaper('a4')->stream('relatório_conteúdos.pdf');
    }
}
