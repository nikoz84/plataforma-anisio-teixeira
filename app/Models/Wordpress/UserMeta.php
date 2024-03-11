<?php

namespace App\Models\Wordpress;

use App\Traits\WPPrefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;use WPPrefix;

    protected $connection = 'mysql';

    protected $table = 'usermeta';

    public $appends = ['role'];

    public function __construct(array $attributes = [])
    {
        $this->table = $this->getPrefix().$this->table;

        parent::__construct($attributes);
    }

    public function getRoleAttribute()
    {
        return unserialize($this['meta_value']);
    }
}
