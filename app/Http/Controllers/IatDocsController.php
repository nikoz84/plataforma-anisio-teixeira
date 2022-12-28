<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class IatDocsController extends Controller
{
    public function iatDocs($rand = false)
    {
        $path = $this->storage::disk('iat-docs');
        $path = $path->getDriver()->getAdapter()->getPathPrefix();
        $files = File::allFiles($path);

        if (!$rand) {
            return collect($files)->map(function ($file) {
                return Storage::disk('iat-docs')->url("{$file->getFilename()}");
            });
        }

        return collect($files)->map(function ($file) {
            return Storage::disk('iat-docs')->url("{$file->getFilename()}");
        })->shuffle();
    }
}
