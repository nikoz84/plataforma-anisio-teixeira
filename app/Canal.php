<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Aplicativo;
use App\AplicativoCategory;
use App\Conteudo;
use App\Category;
use App\Traits\WithoutAppends;

class Canal extends Model
{
    use SoftDeletes, WithoutAppends;

    protected $table = 'canais';
    /**
     * $fillable São todos os atributos que podem ser asignavéis
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'slug',
        'options'
    ];

    protected $hidden = ['token'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $appends = ['tipos', 'category_name'];
    protected $casts = [
        'options' => 'array',
    ];

    public function conteudos()
    {
        return $this->hasMany(Conteudo::class);
    }
    public function aplicativos()
    {
        return $this->hasMany(Aplicativo::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class, 'canal_id', 'id')
            ->where('options->is_active', true)
            ->whereNull('parent_id')
            ->with('subCategories');
    }
    public function appsCategories()
    {
        return $this->hasMany(AplicativoCategory::class, 'canal_id', 'id');
    }

    public function getTiposAttribute()
    {
        $ids = $this->options['tipo_conteudo'];

        if ($ids) {
            return DB::table('tipos')
                ->whereIn('id', $this['options']['tipo_conteudo'])
                ->get(["id", "name"]);
        }

        return [];
    }
    public function getCategoryNameAttribute()
    {
        switch ($this['id']) {
            case 1:
            case 12:
                return 'Programas';
                break;
            case 2:
                return 'Nível de Ensino';
                break;
            case 3:
                return 'Projetos';
                break;
            case 9:
                return 'Categorias';
                break;
            default:
                return "";
                break;
        }
    }
}
