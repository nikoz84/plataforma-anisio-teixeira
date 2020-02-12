<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Aplicativo;
use App\Traits\UserCan;

class AplicativoCategory extends Model
{
    use SoftDeletes, UserCan;

    protected $table = 'aplicativo_categories';
    protected $appends = ['sub_categories', 'user_can'];
    public $fillable = ['name'];

    public function aplicativos()
    {
        return $this->hasMany(Aplicativo::class, 'category_id', 'id');
    }
    public function getSubCategoriesAttribute()
    {
        return [];
    }
}
