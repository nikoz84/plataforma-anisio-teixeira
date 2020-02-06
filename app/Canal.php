<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Helpers\SideBar;
use App\Traits\WithoutAppends;

class Canal extends Model
{
    use SoftDeletes, WithoutAppends;

    protected $table = 'canais';
    protected $id = 'id';
    /**
     * $fillable São todos os atributos que podem ser asignavéis
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'slug',
        'options'
    ];

    protected $hidden = ['token'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $appends = ['tipos'];
    protected $casts = [
        'options' => 'array',
    ];

    public function conteudos()
    {
        return $this->hasMany(\App\Conteudo::class);
    }
    public function aplicativos()
    {
        return $this->hasMany(\App\Aplicativo::class);
    }
    
    public function getTiposAttribute()
    {
        $ids = $this->options['tipo_conteudo'];

        if ($ids) {
            return DB::table('tipos')->whereIn('id', $this['options']['tipo_conteudo'])->get(["id", "name"]);
        }

        return [];
    }
}
