<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Método que lista 
     * @param void
     * @return Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Home', ['user' => 'hola d']);
    }
    /**
     * Método Galeria
     * @return $array
     */
    public function galeria()
    {
        $render = Inertia::render('Galeria', [
            'data' => 'galeria'
        ]);

        return $render;
    }
    /**
     * Método Sobre
     * @param void
     * @return $array
     */
    public function sobre()
    {
        dd(Inertia::render('Sobre'));
        return Inertia::render('Sobre', [
            'data' => 'Sobre'
        ]);
    }
}
