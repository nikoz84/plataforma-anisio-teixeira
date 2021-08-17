<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;
use App\Traits\FileSystemLogic;
use App\Models\Canal;
use App\Helpers\CachingModelObjects;

class CategoryController extends ApiController
{
    /**
     * Cria imagem no banco de dados
     * 
     * @param int $id identificador único
     * @param  \App\Controller\CategoryController\ApiResponser
     * retorna json
     */
    use FileSystemLogic;
    protected $request;

    public function rules()
    {
        return [
            'canal_id' => 'required',
            'parent_id' => 'sometimes|nullable',
            'name'=> 'required|min:2|max:255',
            'imagemAssociada' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable'
        ];
    }
    /**
     * Undocumented function
     * Método Construtor
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth')->except([
            'index', 'search', 'getById', 'getCategoryByCanalId'
        ]);
        $this->request = $request;
    }

    /**
     * Lista as informações do aplicativo 
     * @param \App\Category $categories
     * @return \App\Controllers\ApiResponser
     */ 

    public function index()
    {
        $limit = $this->request->get('limit', 15);
        $categories = Category::whereNull('parent_id')
            ->where('options->is_active', 'true')
            ->with('subCategories')
            ->limit($limit)
            ->orderBy('name', 'asc')
            ->paginate($limit);
        return $this->showAsPaginator($categories);
    }
   /**
    * 
    * Criando e validando informações para ser adicionadas no banco de dados
    * @return void
    */
    public function create()
    {
        dd($this->request->all());
        $validator = Validator::make($this->request->all(), $this->rules());
        if ($validator->fails()) {
            return $this->errorResponse(
                $validator->errors(), 
                "Não foi possível criar a categoria", 
                422
            );
        }
        $category = new Category;

        dd($validator->validate());
        $category->fill($validator->validate());
        dd('dkdi');
        $category->name     = $this->request->name;
        $category->canal_id = $this->request->canal_id;
        $category->options  = json_decode($this->request->options);

        if (!$category->save()) {
            return $this->errorResponse([], 'Não foi possível cadastrar a categoria', 422);
        }
        
        $fileImg = $this->saveFile($category->id, [$this->request->imagemAssociada], 'imagem-associada/categorias');
        
        if(!$fileImg)
        {
            return $this->errorResponse([], 'Não foi possível salvar imagem associada', 422);
        }   
        /*
        if ($this->request->videoDestaque) {
            $fileVideo = $this->saveFile($category->id, [$this->request->videoDestaque], 'visualizacao');
            if (!$fileVideo) {
                return $this->errorResponse([], 'Não foi possível salvar video de destaque', 422);
            }
        }
        */
        return $this->successResponse($category, 'Categoria criada com sucesso!', 200);
    }

    /**
     * Atualiza aplicativo no banco de dados
     * 
     * @param int id identificador único
     * @param  \App\Category $categories
     * @return  \App\Controllers\ApiResponser retorna json
     */
    public function update($id)
    {
        $validator = Validator::make($this->request->all(), $this->rules());
        if ($validator->fails())
        {
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar a categoria", 422);
        }
        $category = Category::findOrFail($id);
        $category->name = $this->request->name;
        $category->canal_id = $this->request->canal_id;
        $category->options = json_decode($this->request->options);
        if ($this->request->imagemAssociada)
        {
            if($category->refenciaImagemAssociada())
            unlink($category->refenciaImagemAssociada());
            $file = $this->saveFile($category->id, [$this->request->imagemAssociada], 'imagem-associada/categorias');
            if(!$file)
            {
                return $this->errorResponse([], 'Não foi possível salvar imagem associada', 422);
            }
        }
        if ($this->request->videoDestaque) 
        {
            if($category->refenciaVideoDestaque())
            unlink($category->refenciaVideoDestaque());
            $fileVideo = $this->saveFile($category->id, [$this->request->videoDestaque], 'visualizacao');
            if (!$fileVideo) {
                return $this->errorResponse([], 'Não foi possível salvar imagem associada', 422);
            }
        }
        if (!$category->update()) {
            return $this->errorResponse([], 'Não foi possível editar', 422);
        }
        return $this->successResponse($category, 'Categoria atualizada com sucesso!', 200);
    }
    /**
     * Deleta aplicativo do banco de dados
     * 
     * @param int $id identificador único
     * @param \App\Category $categories
     * @return \App\Controllers\ApiResponser retorna json
     */

    public function delete($id)
    {
        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean]
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível deletar.", 422);
        }
        $category = Category::findOrFail($id);
        if (!$category->delete()) {
            return $this->errorResponse([], 'Não foi possível deletar a categoria', 422);
        }
        if($category->refenciaImagemAssociada())
            unlink($category->refenciaImagemAssociada());
        if($category->refenciaVideoDestaque())
        unlink($category->refenciaVideoDestaque());
        return $this->successResponse($category, 'Categoria deletada com sucesso!', 200);
    }
     /**
      * 
      * Lista id do aplicativo no banco de dados
      * @param \App\Category $categories
      * @return \App\Controllers\ApiResponser retorna json
      */

    public function getById($id)
    {
        //return $category = Category::findOrFail($id);
        $category = new Category();
        return CachingModelObjects::getById($category->query()->with("canal"), $id);
    }

/**
 * 
 * Lista a categoria do canal por id
 * @param [type] $id
 * @return void
 */
    public function getCategoryByCanalId($id)
    {
        $categories = Category::with('subCategories')->where('canal_id', $id)
        ->where('options->is_active', 'true')
        ->whereNull('parent_id')
        ->orderBy('name')
        ->get();
        
        $canal = Canal::where('id', $id)->get();
        
        $data = collect([
            'category_name' => $canal->pluck('category_name')->first(),
            'categories' => $categories
        ]);

        return $this->showAll($data);
    }

    /**
     * Procura categoria pelo nome
     * @param $request \Illuminate\Http\Request
     * @param $termo string de busca
     * @return App\Traits\ApiResponser
     */
    public function search(Request $request, $termo)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 20;
        $search = "%{$termo}%";
        //$paginator = Category::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search])->paginate($limit);
        $query = Category::whereRaw('unaccent(lower(name)) ILIKE unaccent(lower(?))', [$search]);
        $paginator = CachingModelObjects::search($query, $search, $limit);
        $paginator->setPath("/categorias/search/{$termo}?limit={$limit}");
        return $this->showAsPaginator($paginator, '', 200);
    }
}
