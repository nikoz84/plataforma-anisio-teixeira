<?php

namespace App\Models;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

    use SoftDeletes, UserCan;
    
    public $fillable = ['name'];
    protected $appends = ['user_can'];
    
     /**
     * Função usuario
     * @param \App\Role $role
     * @return \App\Model\ApiResponser retorna json
     */
    public function users()
    {
        //return $this->belongsTo(User::class, 'id', 'role_id');
    }
}
