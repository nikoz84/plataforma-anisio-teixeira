<?php

namespace App;

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
     * Variavel protegida com os campos a ser adcionado e array associativo
     * @param \App\PAsswordReset $password
     * @return \App\Model\ApiResponser retorna json
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
        return $this->where('email', $email)->orderBy("created_at","desc")->first();
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
