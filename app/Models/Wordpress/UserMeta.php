<?php

namespace App\Models\Wordpress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\WPPrefix;

class UserMeta extends Model
{
    use HasFactory, WPPrefix;
    protected $connection = 'mysql';
    protected $table = 'usermeta';


    public $appends = ['role'];


    public function __construct(array $attributes = [])
    {
        $this->table = $this->getPrefix() . $this->table;

        parent::__construct($attributes);
    }


    public function getRoleAttribute()
    {
        return unserialize($this['meta_value']);
    }
}
