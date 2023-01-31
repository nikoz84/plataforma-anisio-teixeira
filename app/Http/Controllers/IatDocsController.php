<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class IatDocsController extends Controller
{
    public function diretorio($id)
    {

        if (!Storage::disk('iat-docs')->exists($id)) {
            return response('Não existe');
        }

        $path  = Storage::disk('iat-docs')->path($id);

        $tree = $this->getTree($path);

        return view('pages.iatDocs', [
            'diretorio' => $this->lerRaiz($path),
            'subdiretorios' => $this->lerSubDiretorio($path),
            'tree'      => $tree
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

    public function getTree($path)
    {
        $tree = [];

        $branch = [
            'label' => basename($path)
        ];


        foreach (File::files($path) as $key => $file) {
            $branch['children'][$key]['file'] = basename($file);
            $branch['children'][$key]['label'] = basename($file);
            $branch['children'][$key]['path'] = $file->getPathname();
            $branch['children'][$key]['url'] = $this->getUrl($file);
        }
        foreach (File::directories($path) as $directory) {
            $branch['children'][] = $this->getTree($directory);
        }

        return array_merge($tree, $branch);
    }

    public function getUrl($file)
    {
        $url = Str::afterLast($file->getPathname(), 'iat-docs');
        return Storage::disk('iat-docs')->url($url);
    }
}