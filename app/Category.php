<?php

namespace App;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, UserCan;

    protected $table = 'categories';
    public $fillable = ['name', 'parent_id', 'options'];
    protected $casts = ['options' => 'array'];
    protected $appends = ['user_can'];

    public function subCategories()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id')
            ->selectRaw("id, parent_id, name")
            ->where('options->is_active', 'true');
    }
}
