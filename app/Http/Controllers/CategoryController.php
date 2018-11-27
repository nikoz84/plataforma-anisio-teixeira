<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct(Category $category, Request $request)
    {
        $this->middleware('jwt.verify')->except(['list','search','getById','getByTagId']);
        $this->category = $category;
        $this->request = $request;
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
        return response()->json([
            'success' => true,
            'categories' => $categories,
        ]);
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
}
