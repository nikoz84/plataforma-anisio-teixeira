<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConteudoLike;

class ConteudoLikeController extends Controller
{
    private $conteudoLike;
    private $request;

	public function __construct(Request $request, ConteudoLike $conteudoLike)
    {
        $this->conteudoLike = $conteudoLike; 
        $this->request = $request;

        $this->middleware('auth:api')->except([
            'create', 
            'update'
        ]);
        $request = $request;
    }

    public function like()
    {

    }

    public function deslike()
    {

    }
}
