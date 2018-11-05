<?php

namespace App\Http\Controllers;

use App\Conteudo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ConteudoController extends Controller
{
    public function __construct()
    {
      $this->middleware('jwt.verify')->except(['list','search']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $limit = ($request->has('limit')) ? $request->query('limit') : 10;

        $orderBy = ($request->has('order')) ? $request->query('order') : 'title';
        $page = ($request->has('page')) ? $request->query('page') : 1;
        $isApproved = $request->query('approved', 'true');
        $isCanal = $request->query('canal', null);
        $canal = (is_null($isCanal)) ?  'canal_id IS NULL' : "canal_id = {$isCanal}";
        $isSite = $request->query('site', 'false');

        $conteudos = Conteudo::select('id','canal_id','user_id','title','options')
                            ->where('is_approved', $isApproved)
                            ->where('is_site', $isSite)
                            ->whereRaw($canal)
                            ->orderBy($orderBy, 'asc')
                            ->paginate($limit);

        $conteudos->setPath("/conteudos?canal={$isCanal}&site={$isSite}&limit={$limit}");    

        return response()->json([
            'success'=> true,
            'title'=> 'Mídias educacionais',
            'paginator'=> $conteudos,
            'page'=> $conteudos->currentPage(),
            'limit' => $conteudos->perPage()
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = DB::table('conteudos')->insertGetId(
            [
                'user_id' => Auth::user()->id,
                'approving_user_id'=> Auth::user()->id,
                'canal_id' => $request->get('canal_id'),
                'title' => $request->get('title'),
                'license_id' => $request->get('license_id'),
                'description' => $request->get('description'),
                'authors' => $request->get('authors'),
                'source' => $request->get('source'),
                'is_featured' => $request->get('is_featured'), 
                'is_approved' => $request->get('is_approved'),
                'is_site' =>  $request->get('is_site'),
                'options' => $request->get('options') 
            ]
        );
        return response()->json([
            'message' => 'Conteúdo cadastrado com sucesso',
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $idConteudo = DB::table('conteudos')
                        ->where('id', $id)
                        ->update( [
                            'title' => $request->get('title'),
                            'description' => $request->get('description'),
                            'authors' => $request->get('authors'),
                            'source' => $request->get('source'),
                            'is_featured' => $request->get('is_featured'), 
                            'is_approved' => $request->get('is_approved'),
                            'is_site' =>  $request->get('is_site'),
                            'options' => $request->get('options')
                        ]);
        
        $conteudo->save($data);

        
        return response()->json($conteudo->toJson());

        
    }
    public function createConteudoTags(Request $request, $id)
    {
        $conteudo = Conteudo::find($id);
        $conteudo->tags()->attach($request->get('tags'));

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $conteudo = Conteudo::find($id);
        $resp = [];
        if(is_null($conteudo)){
            $resp = [
                'menssage' => 'Conteúdo não encontrado',
                'is_deleted' => false
            ];
        }else {
            $resp = [
                'menssage' => "Conteúdo de id: {$id} foi apagado com sucesso!!",
                'is_deleted' => $conteudo->delete()
            ];
        }
        
        return response()->json($resp);
    }

    public function search(Request $request, $termo)
    {
        $limit = $request->query('limit', 15);
        $page = $request->query('page', 1);

        $conteudos = DB::table(DB::raw("conteudos as cd, plainto_tsquery('simple', lower(unaccent('${termo}'))) query"))
                    ->select(['cd.id','cd.title',
                            DB::raw('ts_rank_cd(cd.ts_documento, query) AS ranking')
                            ])
                    ->whereRaw('query @@ cd.ts_documento')
                    ->where('cd.is_approved', '=', 'true' )
                    ->orderBy('ranking','desc')
                    ->paginate($limit);

        
        $conteudos->setPath("/conteudos/search/{$termo}?limit={$limit}");

        return response()->json([
            'success'=> true,
            'message' => 'Resultados da busca',
            'paginator' => $conteudos,
            'has_more_pages' => $conteudos->hasMorePages(),
            'pages'=> $conteudos->count(),
            'page'=> $conteudos->currentPage(),
            'limit' => $conteudos->perPage()
        ]);    
    }

    public function teste(){
        $conteudo = Conteudo::find(4);
        //$conteudo->tags()->detach([1,5]);
        
        
        return response()->json([
            'tags' => $conteudo->tags
        ]);
    }
}

