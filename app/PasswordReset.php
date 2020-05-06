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
    
    // Valida o token
    public function tokenValidation($token)
    {
    	$dados = $this->getToken($token);
    	$horaDoTokenGerado = date('Y-m-d H:i:s', strtotime("+1 hours", strtotime(
    		date('Y-m-d H:i:s', strtotime($dados->created_at))
    	)));

    	$horaDoSistema = date('Y-m-d H:i:s');
       

    	if ($horaDoSistema > $horaDoTokenGerado) {
    		return false;
    	}

    	return true;
    }
}