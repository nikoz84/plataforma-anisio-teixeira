<?php

namespace App\Helpers;

class Analitycs
{
    public function postsPerCanal()
    {
        $sql = "SELECT (SELECT nomecanal FROM canal as c WHERE c.idcanal = cd.idcanal) AS canal,
                COUNT (cd.idcanal) as total
                FROM
                conteudodigital as cd
                WHERE datapublicacao BETWEEN '01/01/2019' AND '22/07/2019'
                and idcanal in (1,12)
                GROUP BY
                cd.idcanal";
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
                from data
                group by 1, idusuariopublicador, usuario
                order by usuario";
    }

    public function postsPerCanalMonth()
    {
        $sql = "with data as (
                    SELECT conteudodigital.idconteudodigital, conteudodigital.datapublicacao, conteudodigital.idcanal,
                      (SELECT upper(canal.nomecanal) FROM canal WHERE canal.idcanal = conteudodigital.idcanal) AS canal
                    FROM conteudodigital
                    WHERE conteudodigital.datapublicacao BETWEEN '01/01/2019' AND '22/07/2019'
                ) select to_char(datapublicacao,'TMMONTH') as mes,
                        canal,
                        case when idcanal = idcanal
                            AND to_char(datapublicacao,'TMMONTH') = to_char(datapublicacao,'TMMONTH')
                            THEN count(idcanal)
                        end as total
                from data
                group by 1, idcanal, canal
                order by canal";
    }
}
