<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Exception;

class RelatorioController extends ApiController
{

    /**
     * listar usuário por role
     *
     * @return \Illuminate\Http\Response
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
        $user = new User();
        $users = $user->users_role_content($role_id, $is_active);

        return PDF::loadView(
            'relatorios.pdf-usuarios',
            compact('users')
        )->setPaper('a4')->stream('relatório_usuários.pdf');
    }

    /**
     * Gerador de relatório de conteúdo (.pdf)
     * @return pdf
     */
    public function gerarPdfConteudo($flag = null)
    {
        $conteudo = new Conteudo();
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

        return PDF::loadView(
            'relatorios.pdf-conteudo',
            compact('conteudos', 'title', 'flag','totalizar')
        )->setPaper('a4')->stream('relatório_conteúdos.pdf');
    }

    public function anosComConteudosPublicados()
    {
        $conteudo = new Conteudo();
        return $conteudo->publicacaoAnos();
    }

    public function conteudosPublicadosPorAno($ano)
    {
        $conteudo = new Conteudo();
        $conteudos = [];
        $flag = 'baixados';
        $title = "Conteúdos publicados no ano de $ano";
        $totalizar = true;
        try{
            $conteudos = $conteudo->conteudosPorAno($ano);
            
            return PDF::loadView('relatorios.pdf-conteudo', compact('conteudos', 'title', 'flag', 'totalizar'))->setPaper('a4')->stream('relatório_conteúdos.pdf');
        }
        catch(Exception $ex)
        {
            return $this->errorResponse([], $ex->getMessage(), $ex->getCode() > 100 && $ex->getCode() < 510 ? $ex->getCode() : 500);
        }
        return $this->errorResponse([], 'Não foi possível gerar relatório. Tente novamente em instantes.', 422);
    }
}
