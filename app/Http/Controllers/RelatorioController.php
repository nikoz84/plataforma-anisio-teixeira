<?php

namespace App\Http\Controllers;

use App\Conteudo;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;

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
     *
     * @return pdf
     */
    public function gerarPdfConteudo($flag = null)
    {
        $content = new Conteudo();

        $contents = [];
        $title = null;

        if ((is_null($flag) || ($flag != 'baixados' && $flag != 'visualizados'))) {
            return $this->errorResponse(
                [],
                "Falta passar segundo paramentro, '/baixados ou /visualizados' ",
                422
            );
        }
        if ($flag == 'baixados') {
            $contents = $content->contents_max_downlaoad();
            $title = 'LISTA DE 100 CONTEÚDOS DIGITAIS MAIS BAIXADOS';
            $flag = 'DOWNLOAD';
        }

        if ($flag == 'visualizados') {
            $contents = $content->contents_max_access();
            $title = 'LISTA DE 100 CONTEÚDOS DIGITAIS MAIS VISUALIZADOS';
            $flag = 'ACESSOS';
        }

        return PDF::loadView(
            'relatorios.pdf-conteudo',
            compact('contents', 'title', 'flag')
        )->setPaper('a4')->stream('relatório_conteúdos.pdf');
    }
}
