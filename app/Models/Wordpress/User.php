<?php

namespace App\Models\Wordpress;

use App\Traits\WPPrefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;use WPPrefix;

    protected $connection = 'mysql';

    protected $table = 'users';

    public function __construct(array $attributes = [])
    {
        $this->table = $this->getPrefix().$this->table;

        parent::__construct($attributes);
    }

    public function userMeta()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'ID')->where('meta_key', 'pw_capabilities');
    }
}
