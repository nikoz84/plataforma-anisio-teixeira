<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }
    public function list(Request $request)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 20;
        $page = ($request->has('page')) ? $request->query('page') : 1;

        $paginator = User::where("options->is_active", 'true')
          ->paginate($limit);

        $paginator->setPath("/users?limit={$limit}");

        return response()->json([
            'success'=> true,
            'title'=> 'Lista de usuários',
            'paginator'=> $paginator,
            'page'=> $paginator->currentPage(),
            'limit' => $paginator->perPage()
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
            'name' => 'required|min:2|max:255',
            'tipo' => 'required',
            'telefone' => 'required',
            'category_id' => 'required'
        ]);

        return $validator;
    }
}
