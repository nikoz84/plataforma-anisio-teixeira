<?php

namespace App\Http\Controllers;

use App\License;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class LicenseController extends ApiController
{
    public function __construct(Request $request, License $license)
    {
        $this->middleware('jwt.verify')->except(['list', 'search']);
        $this->request = $request;
        $this->license = $license;
    }
    /**
     * Lista das licenças.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $limit = $this->request->query('limit', 15);

        if ($this->request->has('select')) {
            $licenses = $this->license::with(['childs' => function ($q) {
                                        $q->select('id', 'parent_id', 'name');
                                    }])->whereRaw('parent_id IS NULL')
                                        ->get(['id', 'parent_id', 'name']);

            return $this->showAll($licenses);
        }

        $licenses = $this->license::with(['childs'])
                                    ->whereRaw('parent_id IS NULL')
                                    ->paginate($limit);

        return $this->showAsPaginator($licenses);
    }

    /**
     * Adiciona nova licença.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $validator = Validator::make($this->request->all(), config("rules.license"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar a licença", 201);
        }

        $license = $this->license;

        $license->fill($this->request->all());

        $license->save();

        return $this->showOne($license, 'Licença registrada com sucesso!!', 200);
    }

    /**
     * Atualiza uma licença específica.
     *
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($this->request->all(), config("rules.license"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar a licença", 201);
        }

        $license = $this->license::find($id);

        $license->fill($this->request->all());

        $license->save();

        return $this->showOne($license, 'Licença atualizada com Sucesso!!', 200);
    }

    /**
     * Apaga uma licença específica.
     *
     * @param  \App\License  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean]
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível deletar a licença", 201);
        }

        $license = $this->license::find($id);
        $license->delete();

        return response()->json([
            'success' => true,
            'message' => 'Licença deletada com sucesso!',
        ]);
    }
    /**
     * Busca por nome da licença.
     *
     * @param   $termo
     * @return \Illuminate\Http\Response
     */
    public function search($termo)
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 20;
        $search = "%{$termo}%";
        $paginator = License::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search])
            ->paginate($limit);

        $paginator->setPath("/licenses/search/{$termo}?limit={$limit}");

        return $this->showAsPaginator($paginator, 'Resultado da busca...', 200);
    }
}
