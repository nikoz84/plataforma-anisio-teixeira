<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class OptionsController extends ApiController
{
    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    /**
     * Display a indexing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->toUser();
        $options = $this->options::all();
        return response()->json([
            'success' => true,
            'options' => $options,
            'user' => $user,
        ]);
    }

    /**
     * Método responsável por criar slider 
     * 
     * @return \Illuminate\Http\Response
     */
    public function createDestaques(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => "required",
                "url" => "required",
                "titulo" => "required",
                "image" => "mimes:jpeg,jpg,png,gif|required|max:10000"
            ]
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o Slider", 422);
        }

        $path = $this->saveFile($request);

        if (!$path) {
            return $this->errorResponse([], "Falha ao fazer upload!", 500);
        }

        $data = $this->newSlider($request, $path);

        if (!$data) {
            return $this->errorResponse([], 'Não foi possível cadastrar o Slider', 422);
        }

        return $this->successResponse($data, 'Slider criado com sucesso!', 201);
    }

    private function newSlider($request, $path = null)
    {
        $data = null;

        $slider =  $this->options::where('name', $request->name)->first();

        $arraySlider = [
            'itens' => [
                [
                    'name' => $request->titulo,
                    'image' => str_replace('\\', '/', $path),
                    'url' => $request->url
                ]
            ]
        ];

        if (isset($slider->meta_data)) {
            $data = $this->options::where('name', $request->name)->first();
            $data->meta_data = [[$arraySlider, $slider->meta_data]];
            $data->update();
        } else {
            $data = $this->options::create([
                'name' => $request->name,
                'meta_data' => [$arraySlider]
            ]);
        };

        return $data;
    }

    public function saveFile($request)
    {
        $path = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $extension = $request->image->extension();
            $name = $request->image->getClientOriginalName();
            $nameFile = "{$name}.{$extension}";

            $path = $request->image->storeAs('public\conteudos\slider', $nameFile);
        }

        return $path;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Options  $options
     * @return \Illuminate\Http\Response
     */
    public function update($name)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Options  $options
     * @return \Illuminate\Http\Response
     */
    public function delete($name)
    {
        //
    }
    public function getByName($name)
    {
        $option = $this->options::where('name', 'like', $name)->first();

        return response()->json([
            'success' => true,
            'options' => $option,
        ]);
    }
}
