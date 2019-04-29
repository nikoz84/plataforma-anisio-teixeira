<?php

namespace App\Http\Controllers;

use App\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
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
    public function list() {

        $licenses = $this->license::with('childs')->whereNull('parent_id')
            ->get();

        return response()->json([
            'success' => true,
            'title' => 'Lista de Licenças',
            'licenses' => $licenses,
        ]);
    }

    /**
     * Adiciona nova licença.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $validator = $this->validar($this->request->all());
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível registrar a licença',
                'errors' => $validator->errors(),
            ], 200);
        }

        $license = $this->license;
        $license->name = $this->request->get('name', '');
        $license->description = $this->request->get('description');
        $license->site = $this->request->get('site');

        $license->save();

        return response()->json([
            'success' => true,
            'message' => 'Licença registrada com sucesso',
            'id' => $license->id,
        ]);
    }

    /**
     * Atualiza uma licença específica.
     *
     */
    public function update($id)
    {
        //
    }

    /**
     * Apaga uma licença específica.
     *
     * @param  \App\License  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
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

        return response()->json([
            'success' => true,
            'title' => 'Resultado da busca',
            'paginator' => $paginator,
        ]);
    }
}
