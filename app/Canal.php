<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Aplicativo;
use App\AplicativoCategory;
use App\Conteudo;
use App\Category;
use App\Traits\UserCan;
use App\Traits\WithoutAppends;

class Canal extends Model
{
    use SoftDeletes, WithoutAppends, UserCan;

    protected $table = 'canais';
    /**
     * $fillable São todos os atributos que podem ser asignavéis
     * @param \App\Canal $canal
     * @return \App\Model\ApiResponser retorna json
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
    protected $appends = ['tipos', 'category_name', 'user_can', 'filters'];
    protected $casts = [
        'options' => 'array',
    ];
    /**
     * Conteúdos digitais
     * @param \App\Canal $canal
     * @return \App\Model\ApiResponser retorna json
     *
     */
    public function conteudos()
    {
        return $this->hasMany(Conteudo::class);
    }
    /**
     * Categoria componente curricular filtros
     * @param \App\Canal $canal
     * @return \App\Model\ApiResponser retorna json
     * 
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
     * Canal aplicativos educacionais
     * @param \App\Canal $canal
     * @return \App\Model\ApiResponser retorna json
     * 
     */
    public function aplicativos()
    {
        return $this->hasMany(Aplicativo::class);
    }
    /**
     * Categorias conteúdos digitais
     * @param \App\Canal $canal
     * @return \App\Model\ApiResponser retorna json
     * 
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
     * Categorias dos aplicativos educacionais
     * @param \App\Canal $canal
     * @return \App\Model\ApiResponser retorna json
     * 
     */
    public function appsCategories()
    {
        return $this->hasMany(AplicativoCategory::class, 'canal_id', 'id')
            ->orderBy("name");
    }
    /**
     * Tipo de conteudos do canal
     * @param \App\Canal $canal
     * @return \App\Model\ApiResponser retorna json
     * 
     */
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
    /**
     * Nome da categoria
     * @param \App\Canal $canal
     * @return \App\Model\ApiResponser retorna json
     * 
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
            default:
                return '';
                break;
        }
    }
    /**
     * Categoria de Filtro do Atributo.
     * @param \App\Canal $canal
     * @return \App\Model\ApiResponser retorna json
     */
    public function getFiltersAttribute()
    {
        switch ($this['id']) {
            case 2:
                return NivelEnsino::where('id', '=', 5)->with(["componentes" => function ($q) {
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
