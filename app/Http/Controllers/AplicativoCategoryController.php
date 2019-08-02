<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AplicativoCategory;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class AplicativoCategoryController extends ApiController
{
    public function __construct(AplicativoCategory $category, Request $request)
    {
        $this->middleware('jwt.verify')->except(['list']);
        $this->category = $category;
        $this->request= $request;
    }
    public function list()
    {
        $categories = $this->category::all();
        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }
    public function create()
    {
        $validator = Validator::make($this->request->all(), config("rules.aplicativo_categoria"));
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Campo nome é obrigatório!", 201);
        }
        $aplicativo_category = $this->category;
        $aplicativo_category->name = $this->request->name;
        if ($aplicativo_category->save()) {
             return $this->successResponse($aplicativo_category, 'Aplicativo categoria criada com sucesso!', 200);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($this->request->all(), config("rules.aplicativo_categoria"));
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar a categoria", 201);
        }
        $aplicativo_category = $this->category;
        $aplicativo_category->name = $this->request->name;
        $cat = $aplicativo_category::findOrFail($id);
        $cat->fill($this->request->all());

        if ($cat->update()) {
            return $this->successResponse($cat, 'Aplicativo categoria editada com sucesso!', 200);
        } else {
            return $this->errorResponse($aplicativo_category, 'Não existe essa categoria para ser atualizada', 200);
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
        //asd 
        $resp = $this->category::findOrFail($id);

        if ($resp->delete()) {
            return $this->successResponse($category, 'Categoria deletada com sucesso!', 200);
        }
    }

    public function getAplicativoCategories($id)
    {
        $category = $this->category::findOrFail($id);
        return $this->showOne($category);
    }
}
