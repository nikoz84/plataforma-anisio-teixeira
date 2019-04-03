<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(Request $request, User $user)
    {
        $this->middleware('jwt.verify')->except(['list','create', 'delete', 'search']);
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * Lista de usuários
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $limit = $this->request->query('limit', 15);
        $orderBy = ($this->request->has('order')) ? $this->request->query('order') : 'created_at';
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;

        return response()->json([
            'success' => true,
            'users' => $this->user::all()
        ]);
    }
    public function getById(Request $request, $id)
    {
    }
    public function delete(Request $request, $id)
    {
        $user = $this->user::find($id);
        $resp = [];
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuário deletado com sucesso!!'
        ]);
    }
    public function search(Request $request, $termo)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 20;
        $search = "%{$termo}%";
        $paginator = User::whereRaw('unaccent(lower(name)) ilike unaccent(lower(?))', [$search])
                    ->paginate($limit);

        $paginator->setPath("/users/search/{$termo}?limit={$limit}");

        return response()->json([
        'success'=> true,
        'title' => 'Resultado da busca',
        'paginator' => $paginator
        ]);
    }
    /**
     * Valida a criação do Usuário
     *
     * @return
     */
    private function validar()
    {
        $validator = Validator::make($this->request->all(), [
            'email' => 'required',
            'name' => 'required|min:2|max:255',
            'role' => 'required',
            'password' => 'required|min:6',
            'nascimento' => 'required',
            'emailinstitucional' => 'required',
            'emailpessoal' => 'required'
        ]);

        return $validator;
    }

    public function create()
    {
        $validator = $this->validar($this->request->all());
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível salvar usuário',
                'errors' => $validator->errors()
            ], 200);
        }

        $user = $this->user;
        $user->email = $this->request->get('login');
        $user->name = $this->request->get('name');
        $user->password = $this->request->get('password');
        $user->options = json_decode($this->request->get('options'), true);

        $resp = $user->save();
        if ($resp) {
            return response()->json([
                'success' => true,
                'message' => 'Usuário registrado com sucesso'
                ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não registrado'
            ]);
        }
    }
}
