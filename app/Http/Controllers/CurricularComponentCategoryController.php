<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\CurricularComponent as Componente;
use App\CurricularComponent;
use App\CurricularComponentCategory as Category;
use App\CurricularComponentCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class CurricularComponentCategoryController extends ApiController
{
    use ApiResponser;
    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except(['index', 'search']);
        $this->request = $request;
    }

    /**
     * @return \Iluminate\Http\JsonResponse
     */
    public function index()
    {
        $limit = $this->request->get('limit', 15);
        $componentesCategoria = CurricularComponentCategory::select("*")
            ->limit($limit)
            ->orderBy('name', 'asc')
            ->paginate($limit);
        return $this->showAsPaginator($componentesCategoria);
    }

    public function getById($id)
    {
        $componentesCategoria = new CurricularComponentCategory();
        try
        {
            $componentesCategoria = CurricularComponentCategory::findOrFail($id);
        }
        catch(Exception $ex)
        {

        }
        return $componentesCategoria;
    }

    public function rules()
    {
        return [
            'name'=> 'required|min:2|max:255'
        ];
    }
}