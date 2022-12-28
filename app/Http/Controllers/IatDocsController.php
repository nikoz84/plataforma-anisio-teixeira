<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class IatDocsController extends Controller
{
    public function iatDocs($id)
    {
        $path = Storage::disk('iat-docs')->path($id);

        $files = File::allFiles($path);

        $directories = Storage::allDirectories();

        return view('pages.iatDocs', ['documentos' => $files, 'diretorios' => $directories]);
    }
}