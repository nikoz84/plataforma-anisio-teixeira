<?php

namespace App\Http\Controllers;

use App\Models\Conteudo;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;

class RelatorioController extends ApiController
{
    /**
     * listar usuário por role
     *
     * @return string json
     */
    public function buscarUsuariosPorRole($role_id)
    {
        $user = User::with('role')
            ->where('role_id', $role_id)
            ->orderBy('role_id', 'asc')
            ->paginate('15');

        return $this->showAsPaginator($user);
    }

    /**
     * Gerador de relatório de usuários por roles (.pdf)
     *
     * @return pdf
     */
    public function gerarPdfUsuario($role_id, $is_active = null)
    {
        $user = new User;
        $users = $user->usersRoleContent($role_id, $is_active);

        return PDF::loadView(
            'relatorios.pdf-usuarios',
            compact('users')
        )->setPaper('a4')->stream('relatório_usuários.pdf');
    }

    /**
     * Gerador de relatório de conteúdo (.pdf)
     *
     * @param $flag null
     * @return pdf
     */
    public function gerarPdfConteudo($flag = null)
    {
        $conteudo = new Conteudo;
        $conteudos = [];
        $title = null;
        $totalizar = false;
        if ((is_null($flag) || ($flag != 'baixados' && $flag != 'visualizados'))) {
            return $this->errorResponse(
                [],
                "Falta passar segundo paramentro, '/baixados ou /visualizados' ",
                422
            );
        }
        if ($flag == 'baixados') {
            $conteudos = $conteudo->relatorioMaisBaixados();
            $title = 'LISTA DE 100 CONTEÚDOS DIGITAIS MAIS BAIXADOS';
            $flag = 'DOWNLOAD';
        }

        if ($flag == 'visualizados') {
            $conteudos = $conteudo->relatorioMaisAcessados();
            $title = 'LISTA DE 100 CONTEÚDOS DIGITAIS MAIS VISUALIZADOS';
            $flag = 'ACESSOS';
        }
        $total = 100;

        return PDF::loadView(
            'relatorios.pdf-conteudo',
            compact('conteudos', 'title', 'flag', 'totalizar', 'total')
        )->setPaper('a4')->stream('relatório_conteúdos.pdf');
    }

    /**
     * anos de publicação de conteudos para construção de menu
     *
     * @return $array
     */
    public function anosComConteudosPublicados()
    {
        $conteudo = new Conteudo;

        return $conteudo->publicacaoAnos();
    }

    /**
     * relatório pdf dos conteúdos por ano de publicação
     *
     * @param  int  $ano
     * @return mixed
     */
    public function conteudosPublicadosPorAno($ano)
    {
        set_time_limit(280);
        $conteudo = new Conteudo;
        $conteudos = [];
        $flag = 'baixados';
        $title = "Conteúdos publicados no ano de $ano";

        $totalizar = true;
        try {
            $conteudos = $conteudo->conteudosPorAno($ano);
            $total = $conteudos->count();

            return PDF::loadView('relatorios.pdf-conteudo', compact('conteudos', 'title', 'flag', 'totalizar', 'total'))->setPaper('a4')->stream('relatório_conteúdos.pdf');
        } catch (Exception $ex) {
            return $this->errorResponse([], $ex->getMessage(), $ex->getCode() > 100 && $ex->getCode() < 510 ? $ex->getCode() : 500);
        }

        return $this->errorResponse([], 'Não foi possível gerar relatório. Tente novamente em instantes.', 422);
    }
}
