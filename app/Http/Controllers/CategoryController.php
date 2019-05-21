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
        if ($this->request->has('canal')) {
            $categories = $this->category::where('canal_id', $this->request->get('canal'))
                ->whereRaw('parent_id is null')
                ->where('options->is_active', 'true')
                ->with('subCategories')
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $categories = $this->category::whereRaw('parent_id is null')
                ->where('options->is_active', 'true')
                ->with('subCategories')->get();
        }
        return $this->getAll($categories, '', 200);
    }
    public function create()
    {
        //
    }
    public function update()
    {
        //
    }
    public function delete()
    {
        //
    }
    public function getAplicativoCategories()
    {
        $categories = $this->appCategory::get();

        return $this->showAll($categories, '', 200);
    }
}
