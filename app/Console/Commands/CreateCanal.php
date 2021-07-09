<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Document;
use Exception;

class CreateCanal extends Command
{
    /**
     * Nome e asinatura do comando
     *
     * @var string
     */
    protected $signature = 'create:canal';

    /**
     * Descrição do comando
     * @var string
     */
    protected $description = 'Cria canal AT';

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
        DB::statement("ALTER TABLE IF EXISTS conteudos_planilha RENAME TO documents;");
        try {
            $docs = DB::table('documents')->where('name', '=', 'canal-anisio-teixeira')->delete();
            $this->info('deletado: ' . $docs);
        } catch (Exception $e){
            $this->info($e->getMessage());
        }

        $document = new Document;
        $document->name = "canal-anisio-teixeira";
        $document->document = [
            "description" => "<p>Anísio Teixeira (1900-1971) atuou como educador, filósofo da educação e gestor de grandes reformas educacionais. Considerado o principal idealizador do atual sistema educacional brasileiro, propôs o ensino público articulado em rede, desde a educação básica até a universidade. Foi um dos signatários do <a href=\"https://pt.wikipedia.org/wiki/Manifesto_dos_Pioneiros_da_Educa%C3%A7%C3%A3o_Nova\" target=\"_blank\">Manifesto dos Pioneiros da Educação Nova (1932)</a> e defendeu, como nenhum outro, a educação pública, gratuita, laica, integral e de qualidade, que associe o desenvolvimento do intelecto com a capacidade de julgamento e ação. </p><p>Baiano de Caetité e bacharel em Direito, Anísio foi Inspetor Geral de Ensino da Bahia, quando implementou diversas reformas no ensino do estado. Assumiu a Secretaria de Educação e Saúde da Bahia em 1947 e, três anos mais tarde, criou em Salvador o Centro Popular de Educação Carneiro Ribeiro, a famosa Escola Parque. Tal iniciativa inspirou a criação dos <a href=\"https://pt.wikipedia.org/wiki/Centros_Integrados_de_Educa%C3%A7%C3%A3o_P%C3%BAblica\" target=\"_blank\">CIEPs</a> por Darcy Ribeiro, no Rio de Janeiro, e, mais recentemente, os CEUs, na cidade de São Paulo.</p><p>Fora da Bahia, Anísio estudou nos Estados Unidos no final dos anos 20 com o filósofo da educação John Dewey, de quem tornou-se discípulo. Foi diretor de Instrução Pública do Rio de Janeiro, criando uma rede municipal de ensino que ia da escola primária à universidade. Em 1951, foi Secretário Geral da <a href=\"https://www.gov.br/capes/pt-br\" target=\"_blank\">CAPES</a> e, no ano seguinte, assumiu a direção do <a href=\"http://portal.inep.gov.br/web/guest/inicio\" target=\"_blank\">INEP</a>, que hoje leva seu nome. À frente do INEP, criou o Centro Brasileiro de Pesquisas Educacionais e os Centros Regionais de São Paulo, Minas Gerais, Rio Grande do Sul, Bahia e Pernambuco. Ao lado de Darcy Ribeiro, foi um dos fundadores da <a href=\"https://www.unb.br/\" target=\"_blank\">Universidade de Brasília</a>, da qual tornou-se reitor em 1963. Lecionou nas Universidades de Colúmbia e da Califórnia, nos Estados Unidos.</p><p>Em 22 de julho de 2020, o governador Rui Costa sancionou a <a href=\"https://leisestaduais.com.br/ba/lei-ordinaria-n-14270-2020-bahia-declara-o-educador-anisio-teixeira-como-patrono-da-educacao-baiana\" target=\"_blank\">Lei n° 23.931/2020</a>, que torna Anísio patrono da Educação na Bahia.</p>",
            "banner" => "/img/canal-at/banner.png",
            "title" => "Canal Anísio Teixeira",
            "sections" => [
                "podcast" => [
                    "label" => "Especial De Podcasts Sobre Anísio Teixeira",
                    "img" => "/img/canal-at/podcast.png"
                ],
                "cordelito" => [
                    "label" => "Leia Nosso Cordelito",
                    "img" => "/img/canal-at/cordelito.png"
                ],
                "conteudos" => [
                    "label" => "Veja Mais Conteúdos Sobre Anísio Teixeira"
                ]
            ]
        ];
        

        $this->info('criado ' . $document->save());
    }

}
