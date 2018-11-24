<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = ['name','parent_id','options'];
    protected $casts = ['options' => 'array',];
    public function subCategories()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id');
    }
}
