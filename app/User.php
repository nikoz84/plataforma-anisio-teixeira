<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email'
    ];
    /**
     * Datas
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * Converte coluna jsonb a array.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];
    /**
     * Usuário tem varios conteudos
     */
    public function conteudos()
    {
        return $this->hasMany('App\Conteudo');
    }
    /**
     * Usuário acessa varios canais
     */
    public function canais()
    {
        return $this->hasMany('App\Canal');
    }
    /**
     * Pega a chave do JSON WEB TOKEN
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Retorna campos 
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
