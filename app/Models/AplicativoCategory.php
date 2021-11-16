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
     * Método Aplicativos
     * 
     * @param \App\AplicativoCategory $aplicativo_categories
     * 
     * @return  relação Tem Muitos Aplicativo
     */
    public function aplicativos()
    {
        return $this->hasMany(Aplicativo::class, 'category_id', 'id');
    }
    /**
     * Método Lista Sub-Categorias do Atributo
     * @param void
     * @return void
     */
    public function getSubCategoriesAttribute()
    {
        return [];
    }
}
