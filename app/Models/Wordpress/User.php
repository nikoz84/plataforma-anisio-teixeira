<?php

namespace App\Models\Wordpress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\WPPrefix;

class User extends Model
{
    use HasFactory, WPPrefix;
    protected $connection = 'mysql';
    protected $table = 'users';

    public function __construct(array $attributes = [])
    {
        $this->table = $this->getPrefix() . $this->table;

        parent::__construct($attributes);
    }



    public function userMeta()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'ID')->where('meta_key', 'pw_capabilities');
    }
}
