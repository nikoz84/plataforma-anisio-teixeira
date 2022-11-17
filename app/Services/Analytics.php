<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Analytics
{
    protected $limit;

    protected $page;

    protected $data_inicio;

    protected $data_fim;

    protected $option;

    protected $render_graph;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->limit = $request->query('limit', 15);
        $this->page = $request->query('page', 1);
        $this->option = $request->query('option', 'per_user');
        $this->data_inicio = $request->query('inicio', date('Y-01-01 00:00:00'));
        $this->data_fim = $request->query('fim', Carbon::now());
    }

    public function postsPerCanal()
    {
        $sql = 'SELECT (SELECT upper(name) FROM canais as c WHERE c.id = cd.canal_id) AS name,
                COUNT (cd.canal_id) as total,
                row_number() OVER () AS id
                FROM
                conteudos as cd
                WHERE created_at BETWEEN ? AND ?
                GROUP BY
                cd.canal_id';

        return DB::select($sql, [$this->data_inicio, $this->data_fim]);
    }

    public function postsPerUser()
    {
        $sql = 'SELECT (SELECT upper(name) FROM users WHERE id = c.user_id) AS name,
                COUNT (c.user_id) as total,
                row_number() OVER () AS id
                FROM
                conteudos as c
                WHERE created_at BETWEEN ? AND ?
                GROUP BY
                c.user_id';

        return DB::select($sql, [$this->data_inicio, $this->data_fim]);
    }

    public function perTypeOfMidia()
    {
        $sql = 'SELECT (SELECT upper(name)
                FROM tipos AS t WHERE t.id = c.tipo_id) as name,
                COUNT (c.tipo_id) as total,
                row_number() OVER () AS id
                FROM
                conteudos AS c
                GROUP BY name';

        return DB::select(DB::raw($sql));
    }

    public function postsPerMonth()
    {
        $sql = "WITH data AS (
                    SELECT id, created_at, user_id,
                        (SELECT upper(name) FROM users WHERE id = user_id) AS name
                    FROM conteudos
                    WHERE created_at BETWEEN ? AND ?
                ) select to_char(created_at,'TMMONTH') AS month,
                    count(user_id) AS total,
                    row_number() OVER () AS id
                FROM data
                GROUP BY month
                ORDER BY month";

        return DB::select($sql, [$this->data_inicio, $this->data_fim]);
    }

    public function postsPerUserMonthly()
    {
        $sql = "WITH data AS (
                    SELECT id, created_at, user_id,
                        (SELECT upper(name) FROM users WHERE id = user_id) AS name
                    FROM conteudos
                    WHERE created_at BETWEEN ? AND ?
                ) SELECT to_char(created_at,'TMMONTH') AS month,
                        name,
                        CASE WHEN user_id = user_id
                            AND to_char(created_at,'TMMONTH') = to_char(created_at,'TMMONTH')
                            THEN count(user_id)
                        END AS total,
                        row_number() OVER () AS id
                FROM data
                GROUP BY 1, user_id, name
                ORDER BY name";

        return DB::select($sql, [$this->data_inicio, $this->data_fim]);
    }

    public function postsPerCanalMonthly()
    {
        $sql = "WITH data AS (
                    SELECT id, created_at, canal_id,
                    (SELECT upper(name) FROM canais WHERE id = canal_id) AS name
                    FROM conteudos
                    WHERE created_at BETWEEN ? AND ?
                ) SELECT to_char(created_at,'TMMONTH') AS month,
                        name,
                        CASE WHEN canal_id = canal_id
                            AND to_char(created_at,'TMMONTH') = to_char(created_at,'TMMONTH')
                            THEN count(canal_id)
                        END AS total,
                        row_number() OVER () AS id
                FROM data
                GROUP BY 1, canal_id, name
                ORDER BY name";

        return DB::select($sql, [$this->data_inicio, $this->data_fim]);
    }

    public function maisBaixados()
    {
        $sql = 'SELECT c.title as name,
                c.qt_downloads as total, id
                FROM conteudos AS c
                ORDER BY c.qt_downloads DESC
                LIMIT 10';

        return DB::select($sql);
    }

    public function maisAcessados()
    {
        $sql = 'SELECT c.title as name,
            c.qt_access as total, id
            FROM conteudos AS c
            ORDER BY c.qt_access DESC
            LIMIT 10';

        return DB::select($sql);
    }

    public function TotalConteudosAcessadosUltimosTresMeses()
    {
        $sql = "SELECT id, title as name, created_at::DATE as data, sum(qt_access) as total,
        CASE WHEN EXTRACT(MONTH from created_at) = 1 THEN
            'Janeiro'
        WHEN EXTRACT(MONTH from created_at) = 2 THEN
            'Fevereiro'
        WHEN EXTRACT(MONTH from created_at) = 3 THEN
            'Março'
        WHEN EXTRACT(MONTH from created_at) = 4 THEN
            'Abril'
        WHEN EXTRACT(MONTH from created_at) = 5 THEN
            'Maio'
        WHEN EXTRACT(MONTH from created_at) = 6 THEN
            'Junho'
        WHEN EXTRACT(MONTH from created_at) = 7 THEN
            'Julho'
        WHEN EXTRACT(MONTH from created_at) = 8 THEN
            'Agosto'
        WHEN EXTRACT(MONTH from created_at) = 9 THEN
            'Setembro'
        WHEN EXTRACT(MONTH from created_at) = 10 THEN
            'Outubro'
        WHEN EXTRACT(MONTH from created_at) = 11 THEN
            'Novembro'
        WHEN EXTRACT(MONTH from created_at)= 12 THEN
        'Dezembro'
        END AS month from conteudos
        WHERE created_at between '01-01-2020' and '01-04-2020' GROUP BY MONTH, data, id, title ORDER BY TOTAL DESC LIMIT 10";

        return DB::select($sql, [$this->data_inicio, $this->data_fim]);
    }

    public function maisBuscadas()
    {
        $sql = 'SELECT name, searched as total, id
            FROM tags
            ORDER BY searched DESC LIMIT 10';

        return DB::select($sql);
    }

    public function aplicativosMaisVisualizados()
    {
        $sql = "SELECT name ,
            cast(options->>'qt_access' AS INTEGER) as total, id
            from aplicativos order by total DESC LIMIT 10";

        return DB::select($sql);
    }

    public function registroMesOcorrencia()
    {
        $sql = "SELECT count(id) as total,
        CASE WHEN action = 'sugerencia' THEN 'sugestao' ELSE action END as name,
        CASE WHEN EXTRACT(MONTH from created_at) = 1 THEN
          'Janeiro'
        WHEN EXTRACT(MONTH from created_at) = 2 THEN
            'Fevereiro'
        WHEN EXTRACT(MONTH from created_at) = 3 THEN
            'Março'
        WHEN EXTRACT(MONTH from created_at) = 4 THEN
            'Abril'
        WHEN EXTRACT(MONTH from created_at) = 5 THEN
            'Maio'
        WHEN EXTRACT(MONTH from created_at) = 6 THEN
            'Junho'
        WHEN EXTRACT(MONTH from created_at) = 7 THEN
            'Julho'
        WHEN EXTRACT(MONTH from created_at) = 8 THEN
            'Agosto'
        WHEN EXTRACT(MONTH from created_at) = 9 THEN
            'Setembro'
        WHEN EXTRACT(MONTH from created_at) = 10 THEN
            'Outubro'
        WHEN EXTRACT(MONTH from created_at) = 11 THEN
            'Novembro'
        WHEN EXTRACT(MONTH from created_at)= 12 THEN
        'Dezembro'
            END AS month
        FROM contatos
        where created_at between '?' and '?'
        group by EXTRACT(MONTH from created_at), action
        order by EXTRACT(MONTH from created_at)";

        return DB::select($sql, [$this->data_inicio, $this->data_fim]);
    }

    public function getData()
    {
        $wordpress = new WordpressService($this->request);
        $d_inicio = new Carbon($this->data_inicio, config('locale'));
        $d_fim = new Carbon($this->data_fim, config('locale'));

        switch ($this->option) {
            case 'per_user':
                $this->render_graph = true;

                return $this->getSeries(
                    $this->postsPerUser(),
                    "Catalogação por usuário publicador na PAT entre as datas {$d_inicio} - {$d_fim}"
                );
                break;
            case 'wordpress_data':
                $this->render_graph = false;

                return collect(
                    $wordpress->getCatalogacao(),
                    "Catalogação por usuário publicador no Blog entre as datas {$d_inicio} - {$d_fim}"
                );
                break;
            case 'per_chanel':
                $this->render_graph = true;

                return $this->getSeries(
                    $this->postsPerCanal(),
                    "Catalogação por canais entre as datas {$d_inicio} - {$d_fim}"
                );
                break;
            case 'user_montly':
                $this->render_graph = false;

                return $this->getSeries($this->postsPerUserMonthly(), 'Catalogação mensal por usuário');
                break;
            case 'per_month':
                $this->render_graph = false;

                return $this->getSeries($this->postsPerMonth(), 'Catalogação mensal');
                break;
            case 'canal_montly':
                $this->render_graph = true;

                return $this->getSeries($this->postsPerCanalMonthly(), 'Catalogação mensal por canal');
                break;
            case 'type_of_midia':
                $this->render_graph = true;

                return $this->getSeries($this->perTypeOfMidia(), 'Tipos de mídia');
                break;
            case 'qt_downloads':
                $this->render_graph = true;

                return $this->getSeries(
                    $this->maisBaixados(),
                    '10 conteúdos mais baixados'
                );
                break;
            case 'qt_access':
                $this->render_graph = true;

                return $this->getSeries(
                    $this->maisAcessados(),
                    '10 conteúdos mais acessados'
                );
                break;
            case 'searched_tags':
                $this->render_graph = true;

                return $this->getSeries(
                    $this->maisBuscadas(),
                    '10 tags mais buscadas'
                );
                break;
            case 'aplicativo_qt_access':
                $this->render_graph = true;

                return $this->getSeries(
                    $this->aplicativosMaisVisualizados(),
                    '10 aplicativos mais visualizados'
                );
                break;
            case 'registro_mes_ocorrencia':
                $this->render_graph = true;

                return $this->getSeries(
                    $this->registroMesOcorrencia(),
                    'Registros de ocorrência de formulário de contatos'
                );
                break;
            case 'acessados_ultimos_meses':
                $this->render_graph = true;

                return $this->getSeries(
                    $this->TotalConteudosAcessadosUltimostresMeses(),
                    '10 conteúdos mais visualizados nos últimos 3 meses'
                );
                break;
            default:
                return $this->postsPerUser();
                break;
        }
    }

    /**
     * Método para gráficos, converte o array associativo em um array simples ou lista
     *
     * @param  Collection  $data intância de collection
     * @return void
     */
    public function getSeries($data, $title = '')
    {
        $collect = collect($data);
        if (!$collect->contains('month')) {
            return [
                'title' => $title,
                'render' => $this->render_graph,
                'data' => $data,
                'categories' => $collect->pluck('name'),
                'series' => $collect->pluck('total'),
            ];
        }
    }
}