<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\WordpressService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

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
        $sql = "SELECT (SELECT upper(name) FROM canais as c WHERE c.id = cd.canal_id) AS name,
                COUNT (cd.canal_id) as total,
                row_number() OVER () AS id
                FROM
                conteudos as cd
                WHERE created_at BETWEEN ? AND ?
                GROUP BY
                cd.canal_id";

        return DB::select($sql, [$this->data_inicio, $this->data_fim]);
    }

    public function postsPerUser()
    {
        $sql = "SELECT (SELECT upper(name) FROM users WHERE id = c.user_id) AS name,
                COUNT (c.user_id) as total,
                row_number() OVER () AS id
                FROM
                conteudos as c
                WHERE created_at BETWEEN ? AND ?
                GROUP BY
                c.user_id";

        return DB::select($sql, [$this->data_inicio, $this->data_fim]);
    }
    public function perTypeOfMidia()
    {
        $sql = "SELECT (SELECT upper(name) FROM tipos WHERE id = cast(c.options->>'tipo' as int)) AS name,
                COUNT (cast(c.options->>'tipo' as int)) as total,
                row_number() OVER () AS id
                FROM
                conteudos as c
                GROUP BY
                name";

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
                return $this->getSeries($this->postsPerUserMonthly(), "Catalogação mensal por usuário");
                break;
            case 'per_month':
                $this->render_graph = false;
                return $this->getSeries($this->postsPerMonth(), "Catalogação mensal");
                break;
            case 'canal_montly':
                $this->render_graph = true;
                return $this->getSeries($this->postsPerCanalMonthly(), "Catalogação mensal por canal");
                break;
            case 'type_of_midia':
                $this->render_graph = true;
                return $this->getSeries($this->perTypeOfMidia(), "Tipos de mídia");
                break;
            default:
                return $this->postsPerUser();
                break;
        }
    }
    /**
     * Método para gráficos, converte o array associativo em um array simples ou lista
     *
     * @param Collection $data intância de collection
     * @return void
     */
    public function getSeries($data, $title = "")
    {
        $collect = collect($data);
        if (!$collect->contains('month')) {
            return [
                'title' => $title,
                'render' => $this->render_graph,
                'data' => $data,
                'categories' => $collect->pluck('name'),
                'series' => $collect->pluck('total')
            ];
        }
    }
}
