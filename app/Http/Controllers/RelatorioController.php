<?php

namespace App\Http\Controllers;

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
        $user = User::with('role')->where('role_id', $role_id)->orderBy('role_id', 'asc')->paginate('15');

        return $this->showAsPaginator($user);
    }

    /**
     * Gerador de relatório de usuários por roles (.pdf)
     *
     * @return pdf
     */
    public function gerarPdfUsuarios($role_id, $is_active)
    {
        $user = new User();
        $users = $user->users_role_content($role_id, $is_active);

        return PDF::loadView('relatorios.pdf-usuarios', compact('users'))->setPaper('a4')->stream('relatório_usuários.pdf');
    }
}
