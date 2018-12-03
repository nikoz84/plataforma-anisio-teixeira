<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AplicativoCategory;

class AplicativoCategoryController extends Controller
{
    public function __construct(AplicativoCategory $category, Request $request)
    {
        die('sdfs');
        $this->middleware('jwt.verify')->except(['list']);
        $this->category = $category;
        $this->request= $request;
    }
    public function list()
    {
        dd("sadsa");
        $categories = $this->category::all()->toSql();
        dd($categories);
        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }
}
