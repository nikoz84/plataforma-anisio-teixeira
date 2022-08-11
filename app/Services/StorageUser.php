<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class StorageUser
{
    public function saveFile(User $user, UserRequest $request)
    {
        $user = User::find($user->id);
        $options = collect($user->options);

        if ($options->has('filename')) {
            $options = $this->removeIfExists($options);
        }

        $filename = $request->file('arquivoImagem')->store(
            null,
            'fotos-perfil'
        );
        Arr::add($options, 'image', Storage::disk('fotos-perfil')->url($filename));
        Arr::add($options, 'filename', $filename);

        $user->update([
            'options' => $options,
        ]);

        return $user;
    }

    private function removeIfExists(Collection $options)
    {
        $path = Storage::disk('fotos-perfil')->path($options->get('filename'));
        if (file_exists($path)) {
            unlink($path);
        }

        array_forget($options, 'image');
        array_forget($options, 'filename');

        return $options;
    }
}
