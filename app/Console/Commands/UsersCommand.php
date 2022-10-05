<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'last:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apresenta os ultimos 100 usuários';

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
        $headers = ['Name', 'Email', 'Criado em'];
        $users = User::select(['name', 'email', 'created_at'])
            ->limit(30)
            ->orderBy('created_at', 'desc')
            ->get()
            ->makeVisible('email')
            ->toArray();

        $this->table($headers, $users);

        /*
        $descricao = "  <div><b>Texto negrito</b> jsalkslkas</div> \n <div><b>Texto negrito</b> jsalkslkas</div>  ";

        $resumo = strip_tags(
            Str::words(
                trim(preg_replace('/\s+/', ' ', $descricao)),
                2
            )
        );
        $user = User::inRandomOrder()->get()->first();
    
        $this->info($resumo);*/
    }
}