<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class FaleconoscoController extends ApiController
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Adiciona novas denúncias
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $validator = Validator::make($this->request->all(), config('rules.faleconosco'));
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Não foi possível enviar a mensagem', 201);
        }
        die();


        $denuncia->name = $this->request->get('name');
        $denuncia->email = $this->request->get('email');
        $denuncia->url = $this->request->get('url');
        $denuncia->subject = $this->request->get('subject');
        $denuncia->message = $this->request->get('message');

        $this->sendToAdminUsers();

        return response()->json([
            'success' => true,
            'message' => 'Sua mensagem foi enviada com sucesso'
        ]);
    }
    private function sendToAdminUsers()
    {
        $users = User::whereRaw("options->>'role' = 'administrador' or options->>'role' = 'super administrador'")->get();

        foreach ($users as $user) {
            Mail::send('emails', [], function ($message) use ($user) {
                $message->from('plataforma-b532cb@inbox.mailtrap.io', 'IAT - Instituto Anísio Teixeira');
                $message->to($user->email)->subject('Nova mensagem');
            });
        }
        return true;
    }

    /**
     * Valida os campos do formulário denúncia
     *
     * @return
     */
    private function validar()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|min:5',
            'email' => 'required',
            'url' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'recaptcha' => 'required'
        ]);

        return $validator;
    }
}
