<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\permissions;

class Role extends Model
{

    use SoftDeletes;

    public $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(App\User::class);
    }
    public function permissions()
    {
        // return $this->hasMany(permissions::class, 'permision_id');
    }
}
