<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AplicativoCategory;

class AplicativoCategoryController extends Controller
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
}
