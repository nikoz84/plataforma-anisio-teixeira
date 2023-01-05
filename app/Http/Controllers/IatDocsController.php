<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;


class IatDocsController extends Controller
{
    public function diretorio($id)
    {

        if (!Storage::disk('iat-docs')->exists($id)) {
            return response('Não existe');
        }

        $path  = Storage::disk('iat-docs')->path($id);

        return view('pages.iatDocs', [
            'diretorio' => $this->lerRaiz($path),
            'subdiretorios' => $this->lerSubDiretorio($path),
        ]);
    }

    public function lerRaiz($path)
    {
        $basename = basename($path);

        return (object)[
            'folder' => $path,
            'folder_name' => $basename,
            'files' => collect(File::files($path))->map(function ($file) {
                return $this->metadata($file);
            })
        ];
    }

    public function metadata($file, $path = '')
    {
        $filename = $file->getFilename();
        $subdiretorio = DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $filename;
        $url = $path ? $subdiretorio : $filename;

        return collect([
            'name' => $file->getFilename(),
            'extension' => $file->getExtension(),
            'size' => $file->getSize(),
            'url' => Storage::disk('iat-docs')->url($url)
        ]);
    }

    public function lerSubDiretorio($path)
    {

        $folders = collect(File::directories($path, true));

        return $folders->map(function ($folder) {
            $basename = basename($folder);

            return (object) [
                'folder' => $folder,
                'folder_name' => $basename,
                'files' => collect(File::files($folder))->map(
                    function ($file) use ($basename) {
                        return $this->metadata($file, $basename);
                    }
                )
            ];
        });
    }
}
