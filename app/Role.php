<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Role extends Model
{

    use SoftDeletes;

    public $fillable = ['name'];

    public function users()
    {
        //return $this->belongsTo(User::class, 'id', 'role_id');
    }
    public function permissions()
    {
        // return $this->hasMany(permissions::class, 'permision_id');
    }
}
