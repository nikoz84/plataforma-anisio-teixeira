<?php

namespace App\Http\Controllers;

use App\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LicenseController extends Controller
{
    public function __construct(Request $request, License $license)
    {
        $this->middleware('jwt.verify')->except(['list','search','create','update']);
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
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 10;
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;

        $paginator = $this->license::with('parent')
                                ->paginate($limit);

        $paginator->setPath("/licenses?limit={$limit}");

        return response()->json([
                'success'=> true,
                'title'=> 'Lista de Licenças',
                'paginator' => $paginator
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
                'errors' => $validator->errors()
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
            'id' => $license->id
        ]);
    }

    /**
     * Atualiza uma licença específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Options  $options
     * @return \Illuminate\Http\Response
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
            'success'=> true,
            'title'=> 'Resultado da busca',
            'paginator' => $paginator
        ]);
    }
}
