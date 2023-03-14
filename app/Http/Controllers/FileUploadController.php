<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileUploadController extends Controller
{

    public function index()
    {
        $folders = array_diff(scandir(public_path('/storage/conteudos/conteudos-digitais/iat-docs/documentos')), array('..', '.'));

        return view('pages.fileUpload', ['folders' => $folders]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'folder' => 'sometimes|required|string|max:255',
            'new_folder' => 'sometimes|required|string|max:255',
            'file' => 'required|file|max:10240',
        ]);

        $folder = $request->input('folder');
        $subfolder = $request->input('subfolder');
        $new_folder = $request->input('new_folder');
        $file = $request->file('file');

        if ($new_folder) {
            $folder = $new_folder;
            if (!file_exists(public_path('storage/conteudos/conteudos-digitais/iat-docs/documentos/' . $folder))) {
                mkdir(public_path('storage/conteudos/conteudos-digitais/iat-docs/documentos/' . $folder));
            }
            if ($subfolder) {
                $folder = $new_folder;
                $subfolder = $subfolder;
            }
        }
        $file->move('storage/conteudos/conteudos-digitais/iat-docs/documentos/' . $folder, '' . $file->getClientOriginalName());

        return redirect('/upload-file')->with('success', 'Arquivo enviado com sucesso!');
    }
}
