<?php

namespace App\Models\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EditorUser extends User
{
    use HasFactory;
    /**
     * Método qeu define o ínicio da tabela  users
     */
    public $table = 'users';
    /**
     * Método inicial que define a edição de users
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('role_id', 4);
        });
    }
}
