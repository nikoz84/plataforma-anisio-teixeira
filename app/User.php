<?php

namespace App;

use App\Traits\UserCan;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes, UserCan;
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
        'role_id'
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

    protected $appends = ['is_admin', 'image', 'user_can'];

    /*public static function boot()
    {
        parent::boot();
        
        static::created(
            function ($user) {
                Event::dispatch('user.saved', $user);
            }
        );
    }*/

    /**
     * Converte o atributo nome para minusculas
     * @param [type] $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim(strtolower($value));
    }

    /**
     * Encripta o atributo password
     * @param $value string
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Atributo nome capitalizado
     * @param $value string retorna o nome capitalizado
     *
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Atributo email a minusculas e tira espaços
     * @param $value string email do usuário
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = trim(strtolower($value));
    }

    /**
     * Comprova se o email do usuário foi verificado
     * @return boolean
     */
    public function isVerified()
    {
        return $this->verified == self::USER_VERIFIED;
    }
    /**
     * Undocumented function
     * @return void
     */
    public function getImageAttribute()
    {
        $path_assoc = $this->referenciaImagem();
        if ($path_assoc) {
            $img_assoc = str_replace($path_assoc, "", $path_assoc);
            return Storage::disk('fotos-perfil')->url("usuario" . $img_assoc);
        }
        return null;
    }

    /**
     * obtem a referencia do arquivo de imagem
     * do usuário se esta existir
     * @return string
     */
    public function referenciaImagem()
    {
        $filesystem = new Filesystem;
        $imagemRef = null;
        $path_assoc = Storage::disk('fotos-perfil')->path('usuario');
        $img_assoc = $path_assoc . "/{$this->id}.*";
        $file = $filesystem->glob($img_assoc);
        if (count($file)) 
        {
            $imagemRef = array_values($file)[0];
        }    
        return $imagemRef;
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function createVerificationToken()
    {
        return  Str::random(40);
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
                'role' => $this->role->id,
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
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getIsAdminAttribute()
    {
        return $this->is('admin');
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

    public function isOwner($user_id)
    {
        return Auth::user()->id == $user_id;
    }
    
    /**
     * Method usado para validação de token por hora
     * @param $token | (String) O token que deve ser passado
     * @param $horaDoTokenCadastradoNoBanco | (Timestamp) da hora que o token foi gerado
     * @param $horasValidas | (Int) Por quantas horas você deseja que o token seja valido
     * @return Boolean
    */
    public function tokenValidatingByHours(string $token, $horaDoTokenCadastradoNoBanco, int $horasValidas)
    {
        $horaDoSistema = date('Y-m-d H:i:s');

        // Formata e valida a hora 
        $horaDoTokenCadastradoNoBanco = date('Y-m-d H:i:s', strtotime("+{$horasValidas} hours", strtotime(
            date('Y-m-d H:i:s', strtotime($horaDoTokenCadastradoNoBanco))
        )));

        if ($horaDoSistema > $horaDoTokenCadastradoNoBanco) {
            return false;
        }

        return true;
    }
    
    // Metodo valida o token de recuperação de senha
    public function verifyToken($token, PasswordReset $passwordReset)
    {
        // Recupera o teken gerado direto da tabela
        $tokenGerado = $passwordReset->getToken($token);
        // Verifica se o token da rota é o mesmo que foi gerado para o usuário
        if ( ! is_null($tokenGerado) && $token == $tokenGerado->token) {
            
            // Verifica se o token ainda está valido
            if (!$this->tokenValidatingByHours($token, $tokenGerado->created_at, 1)) {
                throw new Exception("Token expirou.");
            }
        } 
        else 
        {
            throw new Exception("Token não encontrado!");
        }
        return true ;
    }
    
    // Metodo valida o token de cadastro de usuarios
    public function verifyTokenUserRegister(string $token)
    {
        $user = $this->where('verification_token', $token)->first();

        if ( ! is_null($user)) {

            // Verifica se o token da rota é o mesmo que foi gerado para o usuário
            if ( ! is_null($token) && $token == $user->verification_token) {
                
                if ($this->tokenValidatingByHours($token, $user->created_at, 1)) {
                    // Seta o campo verified como 1, ous seja, usuario validado
                    $user->verified = 1;
                    $user->update();

                    return response()->json([
                        'success' => true,
                        'message' => 'Usuário validado com sucesso!'
                    ]);
                }

                 return response()->json([
                    'success' => true,
                    'message' => 'Este token expirou e não é mais valido!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Este Token não pertence a este usuário!'
            ]);

        } else {
             return response()->json([
                'success' => false,
                'message' => 'Token não encontrado!'
            ]);
        }
    }


    public function users_role_content($role_id, $is_active = null)
    {
        $aux = $is_active ? "and use.options->'is_active' = '{$is_active}'": null;

        $users = DB::select("SELECT use.id, use.options->'is_active' as is_active, use.name as usuario, use.email, rol.name as funcao, count(con.user_id) as total_conteudo
        FROM public.users use
        inner join roles rol on rol.id = use.role_id
        left join conteudos con on con.user_id = use.id
        where use.role_id = {$role_id} {$aux}
        group By (use.id, use.options, use.name, use.email, rol.name)
        order by (use.name) asc");

        return $users;
    }
}
