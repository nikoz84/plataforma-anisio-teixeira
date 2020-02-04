<?php

namespace App\Http\Controllers;

use App\Denuncia;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class DenunciaController extends ApiController
{
    private $denuncia;
    protected $request;

    public function __construct(Request $request, Denuncia $denuncia)
    {
        $this->middleware('jwt.verify')->except(['create']);
        $this->denuncia = $denuncia;
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

        $paginator = $this->denuncia::paginate($limit)->setPath("/denuncias?limit={$limit}");

        return $this->showAsPaginator($paginator, 'Lista de Denúncias', 200);
    }

    /**
     * Adiciona novas denúncias
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $validator = Validator::make($this->request->all(), config('rules.denuncia'));
        if ($validator->fails()) {
            return $this->errorResponse(
                $validator->errors(),
                'Não foi possível fazer o registro, tente novamente',
                422
            );
        }

        $denuncia = $this->denuncia;

        $denuncia->name = $this->request->get('name');
        $denuncia->email = $this->request->get('email');
        $denuncia->action = $this->request->get('action', 'faleconosco');
        $denuncia->url = $this->request->get('url');
        $denuncia->subject = $this->request->get('subject');
        $denuncia->message = $this->request->get('message');

        if (!$denuncia->save()) {
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

        $denuncia = $this->denuncia::find($id);

        if (!$denuncia->delete()) {
            return $this->errorResponse([], "Não foi possível apagar", 422);
        }

        return $this->successResponse([], "Apagado com sucesso!", 200);
    }
    public function getById($id)
    {
        $denuncia = $this->denuncia::findOrFail($id);

        return $this->successResponse($denuncia, "", 200);
    }
}
