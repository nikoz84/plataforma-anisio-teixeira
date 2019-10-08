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

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->limit = $request->query('limit', 15);
        $this->page = $request->query('page', 1);
        $this->data_inicio = $request->query('inicio', date('Y-01-01 00:00:00'));
        $this->data_fim = $request->query('fim', Carbon::now());
    }

    public function postsPerTvAndRadio()
    {
        $sql = "SELECT (SELECT upper(name) FROM canais as c WHERE c.id = cd.canal_id) AS name,
                COUNT (cd.canal_id) as total,
                row_number() OVER () AS id
                FROM
                conteudos as cd
                WHERE created_at BETWEEN ? AND ?
                and cd.canal_id in (1,12)
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
        $per_user = $this->postsPerUser();
        $wordpress_data = collect($wordpress->getCatalogacao());
        $tv_radio = $this->postsPerTvAndRadio();
        $user_montly = $this->postsPerUserMonthly();
        $per_month = $this->postsPerMonth();
        $canal_montly = $this->postsPerCanalMonthly();

        return [
            'title' => "Periodo compreendido entre {$d_inicio->format('d/m/Y')} a {$d_fim->format('d/m/Y')}",
            'blog' => [
                'title' => 'Postagens do Blog',
                'columns' => [
                    ['name' => 'name', 'label' => 'Nome', 'field' => 'name'],
                    ['name' => 'email', 'label' => 'E-mail', 'field' => 'email'],
                    ['name' => 'total', 'label' => 'Total', 'field' => 'total']
                ],
                'data' => $wordpress_data->count() > 0 ? $wordpress_data : [],
                'series' => $this->getSeries($wordpress_data->get('posts'))
            ],
            'tables' => [
                [
                    'title' => 'Catalogação dos canais TV e Radio Anísio Teixeira',
                    'columns' => [
                        ['name' => 'name', 'label' => 'Canal', 'field' => 'name'],
                        ['name' => 'total', 'label' => 'Total', 'field' => 'total']
                    ],
                    'data' => $tv_radio,
                    'series' => $this->getSeries($tv_radio)
                ],
                [
                    'title' => 'Catalogação por Usuário',
                    'columns' => [
                        ['name' => 'name', 'label' => 'Nome', 'field' => 'name'],
                        ['name' => 'total', 'label' => 'Total', 'field' => 'total']
                    ],
                    'data' => $per_user,
                    'series' => $this->getSeries($per_user)
                ],
                [
                    'title' => 'Catalogação Mensal por Usuário',
                    'columns' => [
                        ['name' => 'month', 'label' => 'Mês', 'field' => 'month'],
                        ['name' => 'name', 'label' => 'Nome', 'field' => 'name'],
                        ['name' => 'total', 'label' => 'Total', 'field' => 'total']
                    ],
                    'data' => $user_montly,
                    'series' => $this->getSeries($user_montly)
                ],
                [
                    'title' => 'Catalologação Mensal',
                    'columns' => [
                        ['name' => 'month', 'label' => 'Mês', 'field' => 'month'],
                        ['name' => 'total', 'label' => 'Total', 'field' => 'total']
                    ],
                    'data' => $per_month,
                    'series' => $this->getSeries($per_month)
                ],
                [
                    'title' => 'Catalogação Mensal por Canal',
                    'columns' => [
                        ['name' => 'month', 'label' => 'Mês', 'field' => 'month'],
                        ['name' => 'name', 'label' => 'Canal', 'field' => 'name'],
                        ['name' => 'total', 'label' => 'Total', 'field' => 'total']
                    ],
                    'data' => $canal_montly,
                    'series' =>
                    [
                        'data' => $this->getSeries($canal_montly)
                    ]
                ]
            ]
        ];
    }
    /**
     * Método para gráficos, converte o array associativo em um array simples ou lista
     *
     * @param Collection $data intância de collection
     * @return void
     */
    public function getSeries($data)
    {
        $collect = collect($data);




        return $collect;
        /*
        return $collect->map(function ($item) {

            return [
                'data' => [
                    'x' => $item->name,
                    'y' => $item->total
                ]
            ];
        });
        */
    }
}