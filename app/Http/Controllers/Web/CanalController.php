<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Canal;
use Inertia\Inertia;

class CanalController extends Controller
{
    /**
     * Método pega a slug
     *
     * @param mixed
     * @return Inertia
     */
    public function getBySlug($slug)
    {
        $canal = Canal::with(['categories', 'appsCategories'])
            ->where('slug', $slug)->get()->first();

        if (! $canal) {
            return abort(404);
        }

        return Inertia::render('Canal', [
            'canal' => $canal,
        ]);
    }
}
