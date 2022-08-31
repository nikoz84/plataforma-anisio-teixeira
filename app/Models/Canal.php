<?php

namespace App\Models;

use App\Traits\UserCan;
use App\Traits\WithoutAppends;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Canal extends Model
{
    use SoftDeletes;use WithoutAppends;use UserCan;

    /**
     *  Tabela com campo definido
     */
    protected $table = 'canais';

    /**
     *  Tabela com campos definidos
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'slug',
        'options',
    ];

    /**
     * Método oculto protegido
     */
    protected $hidden = ['token'];

    /**
     * Tabela com campos definidos
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Tabela com campos definidos
     */
    protected $appends = ['tipos', 'category_name', 'user_can', 'filters', 'excerpt'];

    /**
     * Tabela com campo definido
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Conteúdos digitais
     *
     * @param void
     * @return Tem muitos relação com Conteúdo
     */
    public function conteudos()
    {
        return $this->hasMany(Conteudo::class);
    }

    /**
     * Categoria componente curricular filtros
     *
     * @param void
     * @return belongsToMany Pertence a CurricularComponentCategory
     */
    public function filterCategoryCC()
    {
        return $this->belongsToMany(
            CurricularComponentCategory::class,
            'canal_cc_categories',
            'canal_id',
            'category_id'
        )->orderBy('name');
    }

    /**
     * Método Aplicativos
     *
     * @param void
     * @return hasMany Tem muitos relação Aplicativo
     */
    public function aplicativos()
    {
        return $this->hasMany(Aplicativo::class);
    }

    /**
     * Método Categorias
     *
     * @param void
     * @return hasMany Tem muitos relação com Category
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'canal_id', 'id')
            ->where('options->is_active', true)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->with('subCategories');
    }

    /**
     * Método appsCategorias
     *
     * @param void
     * @return hasMany tem muitos relação AplicativoCategory
     */
    public function appsCategories()
    {
        return $this->hasMany(AplicativoCategory::class, 'canal_id', 'id')
            ->orderBy('name');
    }

    /**
     * Método que traz o tipo de Atributo
     *
     * @param void
     * @return void
     */
    public function getTiposAttribute()
    {
        $ids = null;

        if ($this->options && $this->options['tipo_conteudo']) {
            $ids = $this->options['tipo_conteudo'];
        }

        if ($ids) {
            return DB::table('tipos')
                ->whereIn('id', $this['options']['tipo_conteudo'])
                ->get(['id', 'name']);
        }

        return [];
    }

    /**
     * Método Nome da categoria por atributo
     *
     * @param void
     * @return void
     */
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
            case 16:
                return 'Eixos Tecnológicos';
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * Método Resumo do conteúdo
     *
     * @param void
     * @return string sem html
     */
    public function getExcerptAttribute()
    {
        return strip_tags(
            Str::words(
                trim(preg_replace('/\s+/', ' ', $this->description)),
                100
            )
        );
    }

    /**
     * Categoria de Filtro do Atributo.
     *
     * @param void
     * @return void
     */
    public function getFiltersAttribute()
    {
        switch ($this['id']) {
            case 2:
                return NivelEnsino::where('id', '=', 5)->with(['componentes' => function ($q) {
                    $q->where('curricular_components.id', '!=', 31)->orderBy('name');
                }])->get()->first();
                break;
            case 5:
                return CurricularComponentCategory::where('id', '=', 3)
                    ->with(['componentes' => function ($q) {
                        $q->orderBy('name');
                    }])
                    ->get()
                    ->first();
                break;
            default:
                return [];
                break;
        }
    }
}
