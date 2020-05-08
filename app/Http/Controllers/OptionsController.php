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
     * Método responsável por criar destaques 
     * 
     * @return \Illuminate\Http\Response
     */
    public function createDestaques(Request $request)
    {
        $options = $this->options;
        
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
            return $this->errorResponse($validator->errors(), "Não foi possível criar o destaque", 201);
        }

        $path = $this->saveFile($request);

        if (!$path) {
            return $this->errorResponse([], "Falha ao fazer upload!", 500);
        }

        $data = $options::create([
            'name' => $request->name,
            'meta_data' => [
                'itens'=>[
                    [
                        'name'=>$request->titulo,
                        'image'=> str_replace('\\', '/', $path),
                        'url'=> $request->url
                    ]
                ]
            ]
        ]);

        if (!$data) {
            return $this->errorResponse([], 'Não foi possível cadastrar o destaque', 422);
        }
        
        return $this->successResponse($data, 'Destaque criado com sucesso!', 201);
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
