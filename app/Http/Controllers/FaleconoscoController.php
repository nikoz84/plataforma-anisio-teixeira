<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaleconoscoController extends Controller
{
    /**
     * Adiciona novas denúncias
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $validator = $this->validar($this->request->all());
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível registrar a denúncia',
                'errors' => $validator->errors()
            ], 200);
        }

        $google_recap = new GoogleRecaptcha($this->request);
        $resp_recaptcha = $google_recap->validateRecaptcha();
        if (!$resp_recaptcha) {
            return response()->json($resp_recaptcha);
        }

        $faleconosco = $this->faleconosco;
        $faleconosco->name = $this->request->get('name', '');
        $faleconosco->email = $this->request->get('email');
        $faleconosco->url = $this->request->get('url');
        $faleconosco->subject = $this->request->get('subject');
        $faleconosco->message = $this->request->get('message');

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


