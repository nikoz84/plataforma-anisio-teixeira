<?php

namespace App\Models\Wordpress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'at_usermeta';


    public $appends = ['role'];


    public function getRoleAttribute()
    {
        return unserialize($this['meta_value']);
    }
}
