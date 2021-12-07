<?php

namespace App\Models\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminUser extends User
{
    use HasFactory;
    /**
     * Método que define a tabela users
     */
    public $table = 'users';
    /**
     * Método estático de fine o ínicio da pág admin Users
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('role_id', 2);
        });
    }
}
