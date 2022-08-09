<?php

namespace App\Http\Requests;

use App\Traits\RequestValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PlaylistRequest extends FormRequest
{
    use RequestValidator;

    protected $stringify = 'document';

    /**
     * Determine if the user is authorized to make this request.
     * Determine se o usuário está autorizado a fazer essa solicitação.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; /*Auth::check();*/
    }

    /**
     * Get the validation rules that apply to the request.
     * Obtenha as regras de validação que se aplicam à solicitação.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
        ];
    }

    /**
     * Função de Validação
     *
     * @return array
     */
    public function validated()
    {
        if (request()->method() == 'POST') {
            $data = collect($this->toArray());

            return [
                'name' => $this->createSlug($data->get('title')),
                'document' => [
                    'title' => $data->get('title'),
                    'description' => $data->get('description'),
                    'owner' => Auth::user()->id,
                    'ids' => [], //13234, 13233, 13230, 13229
                ],
            ];
        }

        return $this->toArray();
    }

    /**
     * Função que cria slug
     *
     * @return Str slug
     */
    public function createSlug($value)
    {
        return  'pl-'.Str::slug(Str::words($value, 45), '-');
    }
}
