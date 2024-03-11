<?php

namespace App\Console\Commands;

use App\Models\CurricularComponent;
use Illuminate\Console\Command;

class CreateDisciplinasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:disciplinas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $displinas = [
            'Iniciação Científica',
            'Tecnologias Sociais e Ambientais',
            'Matemática Aplicada às Finanças e Consumo',
            'Produção e Interpretação de Texto',
            'Multiculturalismo, Trabalho e Qualidade de Vida',
            'Projeto de Vida e Cidadania',
        ];

        foreach ($displinas as $disciplina) {
            $curricularComponent = new CurricularComponent;

            $curricularComponent->fill([
                'name' => $disciplina,
                'nivel_id' => 5,
            ]);

            if ($curricularComponent->save()) {
                $this->line('criado com sucesso');
            }
        }
    }

}
