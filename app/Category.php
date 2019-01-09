<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = ['name','parent_id','options'];
    protected $casts = ['options' => 'array',];
    
    public function subCategories()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id')->selectRaw("id, parent_id, name, options->>'is_active' AS is_active, options->>'is_featured' AS is_featured");
    }
}
