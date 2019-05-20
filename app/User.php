<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    const USER_VERIFIED = 'TRUE';
    const USER_NOT_VERIFIED = 'FALSE';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTICVE = 0;
    const STATUS_BLOCKED = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'verification_token', 
        'verified',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 'verification_token',
    ];
    /**
     * Datas
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    /**
     * Converte coluna jsonb a array.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    protected $appends = ['is_admin'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function isVerified()
    {
        return $this->verified == App\User::USER_VERIFIED;
    }
    public function getIsAdminAttribute()
    {
        return $this->where('options->role', 'administrador')->exists();
    }
    public static function createVerificationToken()
    {
        return str_random(40);
    }
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
        return ['user' => ['name' => $this['name'], 'id' => $this['id']]];
    }
    public function role()
    {
        //
    }
}
