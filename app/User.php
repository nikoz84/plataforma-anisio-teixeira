<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;
    // email verificado
    const USER_VERIFIED = 'TRUE';
    const USER_NOT_VERIFIED = 'FALSE';
    // user status
    const STATUS_ACTIVE = 1;
    const STATUS_INACTICVE = 0;
    const STATUS_BLOCKED = 2;
    // role default
    const USER_DEFAULT_ROLE = 5;
    /**
     * Atributos asignáveis em massa
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
     * Atributos escondidos do array
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
        'id' => 'integer',
        'options' => 'array',
        'role_id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'verification_token' => 'string',
        'verified' => 'boolean'
    ];

    protected $appends = ['is_admin', 'image'];
    /**
     * Converte o atributo nome para minusculas
     *
     * @param [type] $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
    /**
     * Atributo nome capitalizado
     *
     * @param [type] $value
     * @return void
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Atributo email a minusculas
     *
     * @param [type] $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * Comprova se o email do usuário foi verificado
     *
     * @return boolean
     */
    public function isVerified()
    {
        return $this->verified == App\User::USER_VERIFIED;
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getImageAttribute()
    {

        $image = "{$this['id']}.jpg";
        //dd(Storage::disk('users')->exists("{$image}"));
        return Storage::disk('users')
            ->url("{$image}");
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public static function createVerificationToken()
    {
        return str_random(40);
    }
    /**
     * Relação usuário possui varios conteudos
     */
    public function conteudos()
    {
        return $this->hasMany('App\Conteudo');
    }
    /**
     * Relação usuário pode criar conteúdos em diferentes canais
     *
     * @return array de canais
     */
    public function canais()
    {
        return $this->hasMany('App\Canal');
    }
    /**
     * Chave de Acesso para a API
     *
     * @return void
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Retorna alguns dados do usuário no payload do JWT
     * não enviar dados privados nem sensíveis
     *
     * @return void
     */
    public function getJWTCustomClaims()
    {

        return [
            'user' => [
                'name' => $this['name'],
                'id' => $this['id'],
                'is_admin' => $this->is('admin')
            ]
        ];
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')->select(['id', 'name as label']);
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getIsAdminAttribute()
    {
        return $this->is('super-admin');
    }

    public function is($role_name)
    {
        foreach ($this->role()->get() as $role) {
            if ($role->name == $role_name) {
                return true;
            }
        }
        return false;
    }
    public function updateUser()
    {
        // $user = $this->update([
        //     'name' => 'Luis'
        // ]);

        // $user->save();
    }
}
