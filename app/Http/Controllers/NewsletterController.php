<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class NewsletterController extends ApiController
{
    private $newsletter;
    protected $request;

    public function __construct(Request $request, Newsletter $newsletter)
    {
        $this->middleware('jwt.auth')->except(['create', 'index', 'search', 'getById']);
        $this->newsletter = $newsletter;
        $this->request = $request;
    }

    /**
     * Lista de denúncias
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $limit = $this->request->query('limit', 20);


        $emails = DB::table('newsletter')->orderBy('data', 'asc')->limit($limit)->paginate($limit);


        //print_r($newsletter);
        //die();
        return $this->showAsPaginator($emails);
    }
    /**
     * Regra de Validação
     * @return array  array de regras
     */
    public function configRules()
    {
        return [
            'email' => 'required|email',

        ];
    }
    /**
     * Adiciona ou cria novas denúncias
     *
     * @return string json
     */
    public function create()
    {
        $validator = Validator::make(
            $this->request->all(),
            $this->configRules()
        );

        if ($validator->fails()) {
            return $this->errorResponse(
                $validator->errors(),
                'Não foi possível fazer o registro, tente novamente',
                422
            );
        }


        $email = $this->request->get('email');

        if (DB::table('newsletter')->where('email', $email)->exists()) {
            return $this->errorResponse([], 'Email já cadastrado', 422);
        }
        // print_r($busca_email);

        $newsletter = new Newsletter;


        $newsletter->email = $email;
        $newsletter->data = date('Y-m-d H:i:s');

        // print_r($newsletter->save());
        // die();




        if (!$newsletter->save()) {
            return $this->errorResponse([], 'Não foi possível Cadastrar', 422);
        }

        return $this->successResponse([], 'Email Cadastrado com sucesso!', 200);
    }
    /**
     * Envia para usuários administraivos
     * @return boolean verdadeiro ou falso 
     */
    private function sendToAdminUsers()
    {
    }

    /**
     * Deleta as denúncias
     * @param integer $id Identificador único
     * @return App\Traits\ApiResponser::successResponse 
     * Estrutura padrão de retorno para respostas com sucesso
     */
    public function delete($id)
    {
        $newsletter = new Newsletter;


        $this->authorize('delete', $newsletter);

        if (DB::table('newsletter')->where('id', $id)->exists()) {
            DB::table('newsletter')->where('id', $id)->delete();
            return $this->successResponse([], "Email Deletado com sucesso!", 200);
        }

        if (!$newsletter->delete()) {
            return $this->errorResponse([], "Não foi possível apagar", 422);
        }

        return $this->successResponse([], "Apagado com sucesso!", 200);
    }

    /**
     * Seleciona uma denuncia pelo ID
     *
     * @param integer ID identificador [type] $id 
     * @return void
     */
    public function getById($id)
    {
        $newsletter = $this->newsletter::findOrFail($id);

        return $this->showOne($newsletter);
    }


    /**
     * Procura email no newsletter
     * Faz a Busca do email
     * @param [type] $email
     * @return void
     */
    public function search($email)
    {

        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 10;

        $search = "%{$email}%";



        //$emails = DB::table('newsletter')->where('email', $search)->limit($limit)->paginate($limit);
        // $emails = Newsletter::whereRaw("unaccent(lower(email)) LIKE unaccent(lower(?))")
        //   ->setBindings([$search])
        //    ->paginate($limit);


        $emails = Newsletter::select(['id', 'email'])
            ->whereRaw('unaccent(lower(email)) LIKE unaccent(lower(?))', [$search])

            ->paginate($limit);


        $emails->setPath("/newsletter/search/{$email}?limit={$limit}");

        return $this->showAsPaginator(
            $emails,
            "Resultados da busca pelo termo: {$email}",
            200
        );
    }
}
