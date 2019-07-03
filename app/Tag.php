<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    const INIT_SEARCHED = 0;

    protected $fillable = ['name', 'searched'];
    protected $hidden = ['pivot'];

    public function conteudos()
    {
        return $this->belongsToMany(App\Conteudo::class);
    }
    public function aplicativos()
    {
        return $this->belongsToMany(App\Conteudo::class);
    }
}
