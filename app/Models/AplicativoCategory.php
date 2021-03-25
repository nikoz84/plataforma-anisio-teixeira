<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Aplicativo;
use App\Traits\UserCan;

class AplicativoCategory extends Model
{
    use SoftDeletes, UserCan;

    protected $table = 'aplicativo_categories';
    protected $appends = ['sub_categories', 'user_can'];
    public $fillable = ['name'];
    /**
     * Categoria de Filtro do Aplicativo
     * @param \App\AplicativoCategory $aplicativo_categories
     * @return \App\Model\ApiResponser retorna json
     * @return void
     */
    public function aplicativos()
    {
        return $this->hasMany(Aplicativo::class, 'category_id', 'id');
    }
    public function getSubCategoriesAttribute()
    {
        return [];
    }
}
