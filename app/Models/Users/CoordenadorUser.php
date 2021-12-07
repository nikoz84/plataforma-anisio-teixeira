<?php

namespace App\Models\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoordenadorUser extends User
{
    use HasFactory;
   /**
    * Método  que define a tabela users
    */
    public $table = 'users';
    /**
     * Método estático que define o inicio do user coordenador
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('role_id', 3);
        });
    }
}
