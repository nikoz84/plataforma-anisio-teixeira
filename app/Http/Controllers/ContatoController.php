<?php

namespace App\Http\Controllers;

use App\Contato;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class ContatoController extends ApiController
{
    private $contato;
    protected $request;

    public function __construct(Request $request, Contato $contato)
    {
        $this->middleware('jwt.auth')->except(['create']);
        $this->contato = $contato;
        $this->request = $request;
    }

    /**
     * Lista de denúncias
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = $this->request->query('limit', 15);
        $orderBy = ($this->request->has('order')) ? $this->request->query('order') : 'created_at';
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;

        $paginator = $this->contato::paginate($limit)->setPath("/contato?limit={$limit}");

        return $this->showAsPaginator($paginator);
    }
    
    public function configRules()
    {
        return [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'url' => 'required',
            'subject' => 'required',
            'message' => 'required|min:50|max:300',
            'recaptcha' => ['required', new \App\Rules\ValidRecaptcha],
        ];
    }
    /**
     * Adiciona novas denúncias
     *
     * @return \Illuminate\Http\Response
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

        $contato = $this->contato;

        $contato->name = $this->request->get('name');
        $contato->email = $this->request->get('email');
        $contato->action = $this->request->get('action', 'faleconosco');
        $contato->url = $this->request->get('url');
        $contato->subject = $this->request->get('subject');
        $contato->message = $this->request->get('message');

        if (!$contato->save()) {
            return $this->errorResponse([], 'Não foi possível enviar', 422);
        }

        return $this->successResponse([], 'Enviado com sucesso', 200);
    }

    private function sendToAdminUsers()
    {
        $users = User::whereRaw("options->>'role' = 'administrador' or options->>'role' = 'super administrador'")
            ->get();

        foreach ($users as $user) {
            Mail::send('emails', [], new SendMail($this->request), function ($message) use ($user) {
                $message->from('plataforma-b532cb@inbox.mailtrap.io', 'IAT - Instituto Anísio Teixeira');
                $message->to($user->email)->subject($this->request->subject);
            });
        }

        return true;
    }

    /**
     * Deleta as denúncias
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean]
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível deletar a licença", 422);
        }

        $contato = $this->contato::find($id);

        if (!$contato->delete()) {
            return $this->errorResponse([], "Não foi possível apagar", 422);
        }

        return $this->successResponse([], "Apagado com sucesso!", 200);
    }

    /**
     * Seleciona uma denuncia pelo ID
     *
     * @param [type] $id
     * @return void
     */
    public function getById($id)
    {
        $contato = $this->contato::findOrFail($id);

        return $this->showOne($contato);
    }
}
