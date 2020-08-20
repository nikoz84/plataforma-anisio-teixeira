<?php

namespace App\Http\Controllers;

use App\License;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\NivelEnsino;
use App\Traits\FileSystemLogic;
use Exception;
use Illuminate\Support\Facades\Validator;
use Gate;
use Tymon\JWTAuth\Facades\JWTAuth;

class NivelEnsinoController extends ApiController
{
    use FileSystemLogic;

    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except(['index', 'search']);
        $this->request = $request;
    }

    /**
     * Lista das Niveos de Ensino.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = $this->request->get('limit', 15);
        $niveisensino = NivelEnsino::select("*")
            ->limit($limit)
            ->orderBy('name', 'asc')
            ->paginate($limit);
        return $this->showAsPaginator($niveisensino);
    }
}