<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AplicativoCategory extends Model
{
    protected $table = 'aplicativo_categories';
    public $fillable = ['name'];
}
