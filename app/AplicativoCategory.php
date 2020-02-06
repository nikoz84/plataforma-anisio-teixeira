<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Aplicativo;

class AplicativoCategory extends Model
{
    use SoftDeletes;

    protected $table = 'aplicativo_categories';
    protected $appends = ['sub_categories'];
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
