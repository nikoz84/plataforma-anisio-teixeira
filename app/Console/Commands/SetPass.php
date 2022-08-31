<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetPass extends Command
{
    /**
     * Nome e asinatura do comando
     *
     * @var string
     */
    protected $signature = 'set:pass';

    /**
     * Descrição do comando
     *
     * @var string
     */
    protected $description = 'Muda senha para usuários de homologação';

    /**
     * Criar uma nova instância do commando
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Executar o comando
     *
     * @return mixed
     */
    public function handle()
    {
        $emails = [

        ];

        foreach ($emails as $email) {
            \App\Models\User::where('email', $email)->update(
                [
                    'password' => bcrypt('Mudar@789')
                ]
            );

            $this->info("Password do usuario: {$email}, Atualizado com sucesso! ");
        }

        $this->info('Processo finalizado com sucesso');
    }
}
