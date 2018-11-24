<?php

namespace App\Http\Controllers;

use App\Licenca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LicenseController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('jwt.verify')->except(['list','search']);
        $this->request = $request;
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

        $paginator = License::paginate($limit);

        $paginator->setPath("/licencas?limit={$limit}");
        
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
        //
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
     * @param  \App\License  $termo
     * @return \Illuminate\Http\Response
     */
    public function search($termo)
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 20;

        $paginator = License::where(DB::raw('unaccent(lower(name))'), 'ILIKE', DB::raw("unaccent(lower('%?%'))"))
                    ->setBinding([$termo])
                    ->paginate($limit);
        
        $paginator->setPath("/licencas/search/{$termo}?limit={$limit}");
        
        return response()->json([
            'success'=> true,
            'title'=> 'Resultado da busca',
            'paginator' => $paginator
        ]);
    }
}
