<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Comentario;

class ComentarioController extends ApiController
{
	public function __construct(Request $request)
    {
        $this->middleware('auth:api')->except([
            'create', 'teste'
        ]);
        $request = $request;
    }

    public function create(Request $request)
    {
    	$comentario = new Comentario();
    		dd($comentario->create($request->all()));

    	/*try {
    		$comentario = new Comentario();
    		dd($comentario->create($request->all()));

    		return $this->successResponse([], 'Comentário criado com sucesso!', 200);
    	} catch(\Exception $e) {
    		$this->errorResponse([], 'Não foi possível criar o comentário!', 422);
    	}*/

    }

    public function teste()
    {
    	echo 'Hello';
    }
}
