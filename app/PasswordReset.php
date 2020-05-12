<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UserCan;

class PasswordReset extends Model
{
    protected $table = "password_resets";

    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];
    
    // Recupera o token pelo email do usuário
    public function getTokenByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
    
    // Recupera o token pelo proprio token
    public function getToken($token)
    {
        return $this->where('token', $token)->first();
    }
    
    // Valida o token que vem na url
    public function tokenValidation($token)
    {
        // Pega os dados do token, como email, token, data e hora que foi gerado
        $dadosDoToken = $this->getToken($token);

        // Acrescenta 1h a data que o token foi gerado
        $horaDoTokenGerado = date('Y-m-d H:i:s', strtotime("+1 hours", strtotime(
            date('Y-m-d H:i:s', strtotime($dadosDoToken->created_at))
        )));

        $horaDoSistema = date('Y-m-d H:i:s');
        
        //  Verifica se o token já tem 1h que foi gerado
        if ($horaDoSistema > $horaDoTokenGerado) {
            return false;
        }

        return true;
    }
}
