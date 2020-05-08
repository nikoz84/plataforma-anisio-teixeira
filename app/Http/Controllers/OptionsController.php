<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptionsRequest;
use App\Http\Controllers\ApiController;
use App\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class OptionsController extends ApiController
{
    public function __construct(OptionsRequest $request, Options $options)
    {
        $this->options = $options;
        $this->request = $request;

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

 
    public function createDestaques(Request $request)
    {
        $options = $this->options;
        
        return $this->successResponse($request->all());

        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // $name = uniqid(date('His'));
                $extension = $request->image->extension();
                $name = $request->image->getClientOriginalName(); 
                $nameFile = "{$name}.{$extension}";

                $upload = $request->image->storeAs('conteudos\slider', $nameFile);

                if (!$upload) {
                    return $this->errorResponse([], "Falha ao fazer upload!", 500);
                } else{
                    $options::create([
                        'name' => $request->name,
                        'meta_data' => json_encode(['image' => $nameFile, 'url' => $request->url])
                    ]);
                }
            }

        } catch (\Exception $e) {
            return $this->errorResponse([], "Não foi possível cadastrar o destaque", 422);
        }

        return $this->successResponse($options, 'Destaque criado com sucesso!', 201);
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
