<?php

namespace App\Models;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AplicativoCategory extends Model
{
    use SoftDeletes;use UserCan;

    protected $table = 'aplicativo_categories';

    protected $appends = ['sub_categories', 'user_can'];

    public $fillable = ['name'];

    /**
     * Método Aplicativos
     *
     * @param  \App\AplicativoCategory  $aplicativo_categories
     * @return relação Tem Muitos Aplicativo
     */
    public function aplicativos()
    {
        return $this->hasMany(Aplicativo::class, 'category_id', 'id');
    }

    /**
     * Método Lista Sub-Categorias do Atributo
     *
     * @param void
     * @return void
     */
    public function getSubCategoriesAttribute()
    {
        return [];
    }
}
