<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class Createuser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {email} {name} {password?} {role_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar usuário por linha de comando --email --name --password --role_id';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password') ? $this->argument('password') : 'Mudar789',
            'verified' => true,
            'role_id' => $this->argument('role_id') ? $this->argument('role_id') : 5,
            'options' => [],
        ]);

        $this->line('Usuário criado com sucesso');
    }
}
