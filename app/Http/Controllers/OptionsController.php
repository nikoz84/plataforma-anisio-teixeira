<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class OptionsController extends ApiController
{
    public function __construct(Options $options)
    {
        $this->middleware('jwt.auth')->except(['getByName']);
        $this->options = $options;
    }

    /**
     * Display a indexing of the resource.
     * Exibe uma idexação do recurso
     *
     * @return string json
     */
    public function index()
    {

        $options = $this->options::select(['id', 'name'])->paginate(6);

        return $this->showAsPaginator($options);
    }

    /**
     * Método responsável por criar slider
     * @param Illuminate\Http\Request
     * @return string json
     */
    public function createDestaques(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "url" => "required",
                "title" => "required",
                "image" => "mimes:jpeg,jpg,png,gif|required|max:2000"
            ]
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o Slider", 422);
        }

        //$this->authorize('createDestaque');

        $path = $this->saveFile($request);


        $data = $this->newSlider($request, $path);

        if (!$data) {
            return $this->errorResponse([], 'Não foi possível cadastrar o Slider', 422);
        }

        return $this->successResponse($data, 'Slider criado com sucesso!', 201);
    }
    /**
     * Método Privado
     * @param  mixed $request
     * @param  mixed $path 
     * @return $data
     */
    private function newSlider($request, $path = null)
    {
        $data = null;

        if ($request->disp_alunos == 'true') {
            $css = 'carousel_estudante';
        }

        $newSlide = [
            'title' => $request->title,
            'image' => str_replace('\\', '/', $path),
            'url' => $request->url,
            'css' => $css,

            'filename' => $this->fileName($request)
        ];



        $slider =  $this->options::selectRaw('jsonb_array_length(meta_data) AS length, id, name, meta_data')
            ->where('name', 'slider')->first();

        if (!$slider) {
            $data = $this->options::create([
                'name' => 'slider',
                'meta_data' => [$newSlide]
            ]);
        } else {
            $data = $this->appendSlide($slider, $newSlide);
            $this->deleteLast($slider);
        }

        return $data;
    }
    /**
     * Método Privado Anexar Slider
     * @param mixed $slider
     * @param mixed $newSlider
     * @return mixed $slider
     */
    private function appendSlide($slider, $newSlide)
    {
        $items = $slider->meta_data;
        $append = Arr::prepend($items, $newSlide);
        $slider->setAttribute('meta_data', $append);
        $slider->save();

        return $slider;
    }
    /**
     * Método salve arquivo 
     * @param mixed $request
     * @return mixed $path
     */
    private function saveFile($request)
    {
        $path = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $fileName = $this->fileName($request);

            $path = $request->image->storeAs(
                null,
                $fileName,
                'slider'
            );
            $path = Storage::disk('slider')->url($path);
        }

        return $path ? $path : $this->errorResponse([], "Falha ao fazer upload!", 500);
    }
    /**
     * Método Privado Arquivo por Nome
     * @param $request
     * @return string $filename
     */
    private function fileName($request)
    {
        $extension = $request->image->extension();
        $fileName = explode('.', $request->image->getClientOriginalName());
        $filaName = Str::slug($fileName[0], '-');
        $fileName = "{$filaName}.$extension";

        return $fileName;
    }
    /**
     * Método privado deleta o último slider
     * @param mixed $slider
     * @return Boolean
     */
    private function deleteLast($slider)
    {
        if ($slider->length > 5) {
            $fileName = Arr::last($slider->meta_data)['filename'];
            Storage::disk('slider')->delete($fileName);
            $expression = "meta_data #- '{-1}'";
            return DB::statement("UPDATE options SET meta_data = $expression WHERE name = 'slider'");
        }
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
    /**
     * Função que aciona o as informações por nome
     *
     * @param string $name
     * @return void
     */
    public function getByName($name)
    {
        $option = $this->options::where('name', 'like', $name)->first();

        return response()->json([
            'success' => true,
            'options' => $option,
        ]);
    }
    /**
     * Função que seleciona as informações por id no Banco de Dados.
     *
     * @param integer identificador único $id
     * @return string json
     */
    public function getById($id)
    {
        $option = $this->options::findOrFail($id);

        return $this->showOne($option);
    }
}
