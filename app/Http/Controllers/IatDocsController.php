<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Factory;


class IatDocsController extends Controller
{
    public function diretorio($id)
    {
        // Pega o diretorio principal
        $path = Storage::disk('iat-docs')->path($id);
        return view('pages.iatDocs', [
            'root' => $path, 'tree' => $this->lerDiretorio($path)
        ]);
    }



    public function lerDiretorio($folder)
    {
        // Obtém uma lista de todos os arquivos na pasta raiz
        $rootFiles = File::allFiles($folder);


        // Obtém uma lista de todas as subpastas na pasta raiz
        $rootSubFolders = File::directories($folder);


        //Carrega uma lista 
        $tree = [];

        // Adiciona os arquivos da pasta raiz à lista
        $tree = array_merge([$folder, $rootFiles]);
        // dd($tree);

        // Percorre as subpastas da pasta raiz
        foreach ($rootSubFolders as $subfolder) {

            // Obtém uma lista de todos os arquivos na subpasta atual
            $subfolderFiles = File::files($subfolder);
            // dd($subfolderFiles);
        }
        // Adiciona as subpastas da subpasta atual à lista
        $tree = array_merge($tree, $subfolderFiles);

        // Obtém uma lista de todas as subpastas da subpasta atual
        $subSubfolders = File::directories($subfolder);

        // Adiciona as subpastas da subpasta atual à lista
        $tree = array_merge($tree, $subSubfolders);

        // Repete o processo para cada uma das subpastas da subpasta atual
        foreach ($subSubfolders as $subSubfolder) {
            $subSubfolderFiles = File::files($subSubfolder);
            $tree = array_merge($tree, $subSubfolderFiles);
        }
        // dd($tree);
        return $tree;
    }


    // public function lerSubDiretorio($path)
    // {

    //     $folders = File::directories($path, true);

    //     $files = collect([]);

    //     foreach ($folders as $folder) {
    //         //Metodo put define chave e valor fornecidos na coleção
    //         $files->put($folder, $this->lerDiretorio($folder));
    //     }
    //     dd($files);
    //     return $files->all();
    // }
}