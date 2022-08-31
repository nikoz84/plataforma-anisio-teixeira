<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportData extends Command
{
    /**
     * Nome e asinatura do comando
     *
     * @var string
     */
    protected $signature = 'names:min';

    /**
     * Descrição do comando
     *
     * @var string
     */
    protected $description = 'nomes a minuscula';

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
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            $this->info("Usuário: {$user->name}");
            $user->setAttribute('name', $user->name);

            $user->save();
        }
        $this->info('concluido');
    }

    private function createInitSlider()
    {
        //$url = env('APP_URL');

        \App\Options::create([
            'name' => 'slider',
            'meta_data' => [
                [
                    'image' => '/storage/conteudos/slider/banner-rotinas-de-estudo.png',
                    'filename' => 'banner-rotinas-de-estudo.png',
                    'url' => '/rotinas-de-estudo',
                    'title' => 'Canal de rotinas de estudo',
                ],
                [
                    'image' => '/storage/conteudos/slider/banner-ensino-superior.png',
                    'filename' => 'banner-ensinosuperior.png',
                    'url' => '/ipes',
                    'title' => 'Canal de ensino superior',
                ],
            ],
        ]);
    }
}
