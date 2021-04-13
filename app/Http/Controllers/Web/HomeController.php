<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    
    public function index()
    {
        return Inertia::render('Home', ['user' => 'hola d']);
    }

    public function galeria()
    {
        $render = Inertia::render('Galeria', [
            'data' => 'galeria'
        ]);
        
        return $render;
    }

    public function sobre()
    {
        dd(Inertia::render('Sobre'));
        return Inertia::render('Sobre', [
            'data' => 'Sobre'
        ]);
    }
}
