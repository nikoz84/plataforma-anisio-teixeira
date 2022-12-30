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

        return view('pages.iatDocs', ['root' => $this->lerDiretorio($path), 'subdiretorios' => $this->lerSubDiretorio($path)]);
    }

    public function lerDiretorio($folder)
    {
        $arquivos = collect([]);

        //Lista todos os arquivos
        $files = File::files($folder);
        $arquivos->put($folder, $files);
        return $arquivos;
    }

    public function lerSubDiretorio($path)
    {

        $folders = File::directories($path, true);
        $files = collect([]);


        foreach ($folders as $folder) {

            $files->put($folder, $this->lerDiretorio($folder));
        }

        return $files;
    }
}