<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Aplicativo;

class AplicativoCategory extends Model
{
    use SoftDeletes;

    protected $table = 'aplicativo_categories';
    protected $appends = [];
    public $fillable = ['name'];
}
