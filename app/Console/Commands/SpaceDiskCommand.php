<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SpaceDiskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'space:disk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que indica a capacidade do disco';

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
        
        exec('du -h storage/app', $output);
        $data = [];
        $this->output->progressStart(count($output));
        $count = 0;
        foreach ($output as $item) {
            $data[] = explode("\t", $item);
            $count++;
            $this->output->progressAdvance($count);
            sleep(.7);
        }

        $headers = ['Peso', 'Pasta'];
        
        $this->table($headers, $data);
        $this->output->progressFinish();
    }
}
