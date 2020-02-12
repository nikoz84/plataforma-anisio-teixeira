<?php

namespace App;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use App\Conteudo;

class License extends Model
{
    use UserCan;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'site', 'parent_id',
    ];
    protected $appends = ['user_can'];
    public function conteudo()
    {
        return $this->belongsTo(Conteudo::class, 'license_id');
    }

    public function childs()
    {
        return $this->hasMany(\App\License::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->hasOne(\App\License::class, 'id', 'parent_id');
    }
}
