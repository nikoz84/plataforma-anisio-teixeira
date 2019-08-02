<?php

namespace App\Http\Controllers;

use App\Category;
use App\AplicativoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;

class CategoryController extends ApiController
{
    private $appCategory;
    private $category;
    protected $request;

    public function __construct(Request $request, AplicativoCategory $appCategory, Category $category)
    {
        $this->middleware('jwt.verify')->except([
            'list', 'search', 'getById', 'getByTagId', 'getAplicativoCategories'
        ]);
        $this->category = $category;
        $this->request = $request;
        $this->appCategory =  $appCategory;
    }

    public function list()
    {
        $limit = $this->request->get('limit', 15);

        if ($this->request->has('canal')) {
            $categories = $this->category::where('canal_id', $this->request->get('canal'))
                ->whereRaw('parent_id is null')
                ->where('options->is_active', 'true')
                ->with('subCategories')
                ->limit($limit)
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $categories = $this->category::whereRaw('parent_id is null')
                ->where('options->is_active', 'true')
                ->limit($limit)
                ->with('subCategories')->get();
        }
        return $this->showAll($categories, '', 200);
    }
    public function create()
    {
        $validator = Validator::make($this->request->all(), config("rules.categoria"));
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o perfil", 201);
        }
        $category = $this->category;
        $category->name = $this->request->name;
        $category->canal_id = $this->request->canal_id;
        $category->options = $this->request->options;

        if ($category->save()) {
            return $this->successResponse($category, 'Categoria criada com sucesso!', 200);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($this->request->all(), config("rules.categoria"));
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar a categoria", 201);
        }

        $category = $this->category;
        $category->name = $this->request->name;
        $category->canal_id = $this->request->canal_id;
        $category->options = $this->request->options;

        $cat = $this->category::find($id);
        $cat->fill($this->request->all());

        if ($cat->update()) {
            return $this->successResponse($cat, 'Categoria editada com sucesso!', 200);
        } else {
            return $this->errorResponse($category, 'Não existe essa categoria para ser atualizada', 200);
        }
    }
    public function delete($id)
    {
        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean]
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível deletar.", 201);
        }
        $category = $this->category;
        $resp = $this->category::findOrFail($id);

        if ($resp->delete()) {
            return $this->successResponse($category, 'Categoria deletada com sucesso!', 200);
        }
    }
    public function getCategoryById($id)
    {
        $category = $this->category::find($id);
        return $this->showOne($category);
    }
    // public function getAplicativoCategories()
    // {
    //     $categories = $this->appCategory::get();
    //     return $this->showAll($categories, '', 200);
    // }
}
