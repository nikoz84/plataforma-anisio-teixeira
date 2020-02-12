<?php

namespace App;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

    use SoftDeletes, UserCan;

    public $fillable = ['name'];
    protected $appends = ['user_can'];
    public function users()
    {
        //return $this->belongsTo(User::class, 'id', 'role_id');
    }
}
