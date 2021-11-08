<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Traits\FileSystemLogic;
use Exception;
use Illuminate\Support\Facades\Validator;
use Gate;
use Tymon\JWTAuth\Facades\JWTAuth;

class LicenseController extends ApiController
{
    use FileSystemLogic;

    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except(['index', 'search']);
        $this->request = $request;
    }
    /**
     * Lista das licenças.
     *
     * @return string json
     */
    public function index()
    {
        $limit = $this->request->query('limit', 15);

        if ($this->request->has('select')) {
            $licenses = License::with(['childs' => function ($q) {
                $q->select('id', 'parent_id', 'name');
            }])->whereRaw('parent_id IS NULL')
                ->get(['id', 'parent_id', 'name']);

            return $this->showAll($licenses);
        }

        $licenses = License::with(['childs'])
            ->whereRaw('parent_id IS NULL')
            ->paginate($limit);

        return $this->showAsPaginator($licenses);
    }

    protected function config()
    {
        return [
            'name' => 'required|min:2|max:255',
            'description' => 'required|min:32|max:512'
        ];
    }

    /**
     * Adiciona nova licença.
     * @return string json
     */
    public function create()
    {
        $validator = Validator::make($this->request->all(), $this->config());
        $license = new License;
        $data = [];
        try {
            if ($validator->fails()) {
                $data = $validator->errors();
                throw new Exception("Não foi possível criar a licença", 422);
            }
            $this->authorize('create', JWTAuth::user());
            $license->fill($this->request->all());
            if (!$license->save()) {

                throw new Exception('Não foi possível salvar imagem associada', 422);
            }
            if ($this->request->imagemAssociada) {
                $fileImg = $this->saveFile($license->id, [$this->request->imagemAssociada], 'imagem-associada' . DIRECTORY_SEPARATOR . "licencas");
                if (!$fileImg) {
                    throw new Exception("Não foi possível salvar imagem. Tente novamente mais tarde.", 501);
                }
            }
        } catch (Exception $ex) {
            return $this->errorResponse($data, $ex->getMessage(), 422);
        }
        return $this->successResponse($license, 'Licença registrada com sucesso!!', 200);
    }

    /**
     * Atualiza uma licença específica.
     *@param int $id parametro identificador do objeto em questão
     *@return License objeto de licenca atualizado
     */
    public function update($id)
    {
        try {
            $license = License::find($id);
            $this->authorize('update', $id);
            $validator = Validator::make($this->request->all(), $this->config());
            if ($validator->fails()) {
                throw new Exception('Não foi possível salvar imagem associada');
            }
            if ($this->request->imagemAssociada) {
                if ($license->refenciaImagemAssociada())
                    unlink($license->refenciaImagemAssociada());
                $file = $this->saveFile($license->id, [$this->request->imagemAssociada], 'imagem-associada' . DIRECTORY_SEPARATOR . 'licencas');
                if (!$file) {
                    throw new Exception('Não foi possível salvar imagem associada');
                }
            }
            $license->fill($this->request->all());
            $license->save();
        } catch (Exception $ex) {
            return $this->errorResponse([], $ex->getMessage(), 422);
        }
        return $this->showOne($license, 'Licença atualizada com Sucesso!!', 200);
    }

    /**
     * Apaga uma licença específica.
     * @param  \App\License  $id
     * @return string json
     */
    public function delete($id)
    {
        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean]
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível deletar a licença", 422);
        }
        $license = License::findOrFail($id);
        $this->authorize('delete', $license);
        if (!$license->delete()) {
            $this->errorResponse([], 'não foi possível deletar a licença', 422);
        }
        return $this->successResponse($license, 'Licença apagada com sucesso!', 200);
    }

    /**
     * Busca por nome da licença.
     * @param   $termo
     * @return  string - json
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

    /**
     * Metodo para retorno da licença em expecifico, ou objeto nulo em json
     * @param int $id identificador unico da licença
     * @return License objeto de licenca relacionado ao id 
     */
    public function getById($id)
    {
        $licenca = License::find($id);
        return $this->showOne($licenca);
    }
}
