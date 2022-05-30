<?php

namespace App\Models\Wordpress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'at_users';

    public function userMeta()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'ID')->where('meta_key', 'pw_capabilities');
    }
}
