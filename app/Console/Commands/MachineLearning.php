<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;
use Phpml\Dataset\CsvDataset;

class MachineLearning extends Command
{
    /**
     * Nome e asinatura do comando
     *
     * @var string
     */
    protected $signature = 'ml:start {f} {h}';

    /**
     * Descrição do comando
     *
     * @var string
     */
    protected $description = "Teste de machine learning no linha de comandos\n
    f= integer que especifica el numero de colunas em nosso arquivo\n
    h= boolean que indica se a primeira linha tem um header ou não";

    protected $columnNames;

    protected $samples;

    protected $targets;

    /**
     * Criar uma nova instância do commando
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->file = storage_path('dumps\Tweets.csv');
    }

    public function handle()
    {
        $heading = $this->argument('h');
        $features = $this->argument('f');

        if (! file_exists($this->file)) {
            throw FileException::missingFile(basename($this->file));
        }
        $file = explode("\n", file_get_contents($this->file));
        $this->columnNames = $file[0];

        //$dataset = new CsvDataset($this->file, $columns, $heading);

        /*
        $dataset->removeColumns([0,3,4]);
        $dataset->getTargets(['airline_sentiment','airline_sentiment_confidence']);
        */
        //$data = array_slice($file[0], 0, $features);
        foreach ($file as $line => $value) {
            if ($line != 0) {
                $data = explode(',', $value);
                print_r($data);
                $this->samples[] = array_slice($data, 0, $features);
                //$this->targets[] = $data[$features];
            }
        }
        print_r($this->samples);
    }
}
