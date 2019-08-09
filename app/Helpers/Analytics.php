<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Analytics
{
    protected $limit;
    protected $page;
    protected $data_inicio;
    protected $data_fim;

    public function __construct(Request $request)
    {
        $this->limit = $request->query('limit', 15);
        $this->page = $request->query('page', 1);
        $this->data_inicio = $request->query('inicio', date('Y-01-01 00:00:00'));
        $this->data_fim = $request->query('fim', date("Y-m-d H:i:s"));

    }

    public function postsPerTveRadio()
    {
        $sql = "SELECT (SELECT name FROM canais as c WHERE c.id = cd.canal_id) AS canal,
                COUNT (cd.canal_id) as total
                FROM
                conteudos as cd
                WHERE created_at BETWEEN '01/01/2019' AND '22/07/2019'
                and cd.canal_id in (1,12)
                GROUP BY
                cd.canal_id";

        return DB::select($sql);
    }

    public function postsPerUser()
    {
        $sql = "SELECT (SELECT nomeusuario FROM usuario WHERE idusuariopublicador = idusuario) AS usuario,
                COUNT (idusuariopublicador) as total
                FROM
                conteudodigital
                WHERE datapublicacao BETWEEN '01/01/2019' AND '22/07/2019'
                GROUP BY
                idusuariopublicador";

        return DB::select($sql);
    }

    public function postsPerMonth()
    {
        $sql = "WITH data AS (
                    SELECT idconteudodigital, datapublicacao, idusuariopublicador,
                        (SELECT nomeusuario FROM usuario WHERE idusuariopublicador = idusuario) AS usuario
                    FROM conteudodigital
                    WHERE datapublicacao BETWEEN '01/01/2019' AND '22/07/2019'
                ) select to_char(datapublicacao,'TMMONTH') as mes,
                    count(idusuariopublicador) as total
                FROM data
                GROUP BY 1";

        return DB::select($sql);
    }

    public function postsPerUserMonth()
    {
        $sql = "WITH data AS (
                    SELECT idconteudodigital, datapublicacao, idusuariopublicador,
                        (SELECT upper(nomeusuario) FROM usuario WHERE idusuariopublicador = idusuario) AS usuario
                    FROM conteudodigital
                    WHERE datapublicacao BETWEEN '01/01/2019' AND '22/07/2019'
                ) select to_char(datapublicacao,'TMMONTH') as mes,
                        usuario,
                        case when idusuariopublicador = idusuariopublicador
                            AND to_char(datapublicacao,'TMMONTH') = to_char(datapublicacao,'TMMONTH')
                            THEN count(idusuariopublicador)
                        end as total
                FROM data
                GROUP BY 1, idusuariopublicador, usuario
                ORDER BY usuario";

        return DB::select($sql);
    }

    public function postsPerCanalMonth()
    {
        $sql = "WITH data AS (
                    SELECT conteudodigital.idconteudodigital, conteudodigital.datapublicacao, conteudodigital.idcanal,
                      (SELECT upper(canal.nomecanal) FROM canal WHERE canal.idcanal = conteudodigital.idcanal) AS canal
                    FROM conteudodigital
                    WHERE conteudodigital.datapublicacao BETWEEN '01/01/2019' AND '22/07/2019'
                ) SELECT to_char(datapublicacao,'TMMONTH') AS mes,
                        canal,
                        CASE WHEN idcanal = idcanal
                            AND to_char(datapublicacao,'TMMONTH') = to_char(datapublicacao,'TMMONTH')
                            THEN count(idcanal)
                        END AS total
                FROM data
                GROUP BY 1, idcanal, canal
                ORDER BY canal";

        return DB::select($sql);
    }
}
