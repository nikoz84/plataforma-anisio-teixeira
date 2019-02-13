<?php

namespace App\Http\Controllers;

use App\Denuncia;
use Illuminate\Http\Request;
use Validator;
use App\User;
use Mail;
use App\Helpers\GoogleRecaptcha;

class DenunciaController extends Controller
{
    public function __construct(Request $request, Denuncia $denuncia)
    {
        $this->middleware('jwt.verify')->except(['list','create']);
        $this->denuncia = $denuncia;
        $this->request = $request;
    }
    /**
     * Lista de denúncias
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $limit = $this->request->query('limit', 15);
        $orderBy = ($this->request->has('order')) ? $this->request->query('order') : 'created_at';
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;

        return response()->json([
            'success' => true,
            'denuncias' => $this->denuncia::all()
        ]);
    }

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

        $denuncia = $this->denuncia;
        $denuncia->name = $this->request->get('name');
        $denuncia->email = $this->request->get('email');
        $denuncia->url = $this->request->get('url');
        $denuncia->subject = $this->request->get('subject');
        $denuncia->message = $this->request->get('message');

        $resp = $denuncia->save();
        if (!$resp) {
            return response()->json([
                'success' => false,
                'message' => 'Denúncia não registrada'
            ]);
        }
        $this->sendToAdminUsers(); // Envio de email a usuários admin e super admin

        return response()->json([
            'success' => true,
            'message' => 'Denúncia registrada com sucesso'
        ]);
    }

    private function sendToAdminUsers()
    {
        $users = User::whereRaw("options->>'role' = 'administrador' or options->>'role' = 'super administrador'")->get();

        foreach ($users as $user) {
            Mail::send('emails', [], function ($message) use ($user) {
                $message->from('plataforma-b532cb@inbox.mailtrap.io', 'IAT - Instituto Anísio Teixeira');
                $message->to($user->email)->subject('Nova denúncia');
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
        $denuncia = Denuncia::find($id);
        $resp = [];
        if (!$denuncia) {
            $resp = [
                'menssage' => 'Não foi possível deletar a denúncia',
                'success' => false
            ];
        } else {
            $resp = [
                'menssage' => "Denúncia de id: {$id} foi apagado com sucesso!!",
                'success' => $denuncia->delete()
            ];
        }

        return response()->json($resp);
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
