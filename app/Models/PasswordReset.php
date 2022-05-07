<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UserCan;

class PasswordReset extends Model
{  
     
    #Tabela Protegida uso do password e reset
    protected $table = "password_resets";
    
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    
     /**
     * variaveis que serão adicionadas quando se utiliza o metodo fill
     */
    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];
    
    /**
     * Recupera o token pelo email do usuário
     * @param \App\PasswordReset $password
     * @return \App\Model\ApiResponser retorna json
     */
     
    public function getTokenByEmail($email)
    {
        return $this->where('email', $email)->orderBy("created_at", "desc")->first();
    }
    
    /**
     * Recupera o token pelo proprio token
     * @param \App\PasswordReset $password
     * @return \App\Model\ApiResponser retorna json
     */
    public function getToken($token)
    {
        return $this->where('token', $token)->first();
    }
}
