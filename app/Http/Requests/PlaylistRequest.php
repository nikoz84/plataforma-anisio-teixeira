<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\RequestValidator;
use Illuminate\Support\Str;

class PlaylistRequest extends FormRequest
{
    use RequestValidator;

    protected $stringify = 'document';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required'
        ];
    }

    public function validated()
    {
        
        if (request()->method() == "POST") {
            
            $data = collect($this->toArray());

            return [
                'name' => $this->createSlug($data->get('title')),
                'document' => [
                    'title' => $data->get('title'),
                    'description' => $data->get('description'),
                    'owner' => Auth::user()->id,
                    'ids' => [] //13234, 13233, 13230, 13229
                ]
            ];
            
        }

        return $this->toArray();
    }

    public function createSlug($value)
    {
        return  "pl-" . Str::slug(Str::words($value, 45), '-');
    }
}
