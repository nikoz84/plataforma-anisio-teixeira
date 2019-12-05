<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AplicativoCategory extends Model
{
    use SoftDeletes;

    protected $table = 'aplicativo_categories';
    protected $appends = ['sub_categories'];
    public $fillable = ['name'];

    public function getSubCategoriesAttribute()
    {
        return [];
    }
}
