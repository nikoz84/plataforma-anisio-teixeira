<?php

namespace App\Models;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @property Canal $canal
 */
class Category extends Model
{
    use SoftDeletes, UserCan;
    /**
     * Tabela com campo definido
     */
    protected $table = 'categories';
    /**
     * Tabela com campos definidos
     */
    public $fillable = ['name', 'parent_id', 'options', 'canal_id'];
    /**
     * Tabela com campo definido
     */
    protected $casts = ['options' => 'array'];
    /**
     * Tabela com campos definidos
     */
    protected $appends = ['user_can', 'image', 'video'];

    /**
     * Método SubCategorias
     * @param void
     * @return hasMany Tem muitos relacionamento Category \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories()
    {
        return $this->hasMany(\App\Models\Category::class, 'parent_id', 'id')
            ->selectRaw("id, parent_id, name")
            ->where('options->is_active', true)
            ->orderBy('name');
    }

    /**
     * Método referencia de video destaque
     * @param void
     * @return void
     */
    public function refenciaVideoDestaque()
    {
        if (!$this->id)
            return null;
        $urlPath = Storage::disk("conteudos-digitais")->path("visualizacao");
        $urlPath = $urlPath . DIRECTORY_SEPARATOR . $this->id . ".*";
        $info = glob($urlPath);
        if (sizeof($info) > 0)
            return $info[0];
        return null;
    }

    /**
     * Método referencia do arquivo de imgame associada
     * @param void
     * @return void
     */
    public function refenciaImagemAssociada()
    {
        if (!$this->id)
            return null;
        $urlPath = Storage::disk("conteudos-digitais")->path("imagem-associada" . DIRECTORY_SEPARATOR . "categorias");
        $urlPath = $urlPath . DIRECTORY_SEPARATOR . $this->id . ".*";
        $info = glob($urlPath);
        if (sizeof($info) > 0)
            return $info[0];
        return null;
    }

    /**
     * Método Imagem do Atributo
     * @param void
     * @return void
     * 
     */
    public function getImageAttribute()
    {
        //return $urlPath;
        $filename = basename($this->refenciaImagemAssociada());
        if ($this->canal_id == 2) {
            return Storage::disk('conteudos-digitais')->url("imagem-associada/sinopse/" . $filename);
        }
        if ($filename) {
            return Storage::disk("conteudos-digitais")->url("imagem-associada/categorias/" . $filename);
        }

        return null;
    }

    /**
     * Método url do video destaque da categoria
     * @param void
     * @return void
     * 
     */
    public function getVideoAttribute()
    {
        //return $urlPath;
        $filename = basename($this->refenciaVideoDestaque());
        if ($filename)
            return Storage::disk("conteudos-digitais")->url("visualizacao/" . $filename);
        return null;
    }

    /**
     * Método Canal
     * BelongsTo pertence a canal
     * @param void
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function canal()
    {
        return $this->belongsTo(Canal::class, 'canal_id', 'id');
    }
}
