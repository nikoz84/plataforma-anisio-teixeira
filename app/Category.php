<?php

namespace App;

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

    protected $table = 'categories';
    public $fillable = ['name', 'parent_id', 'options', 'canal_id'];
    protected $casts = ['options' => 'array'];
    protected $appends = ['user_can', 'image', 'video'];
     
    /**
     * Ordena o arquivo por nome 
     * @param \App\Category $category
     * @return \App\Model\ApiResponser retorna json
     * @return void
     */
    public function subCategories()
    {
        return $this->hasMany(\App\Category::class, 'parent_id', 'id')
            ->selectRaw("id, parent_id, name")
            ->where('options->is_active', true)
            ->orderBy('name');
    }

    /**
     * obtem referencia do arquivo de video destaque
     * da categoria do conteudo em questão
     * @param \App\Category $category
     * @return \App\Model\ApiResponser retorna json
     * @return string
     */
    public function refenciaVideoDestaque()
    {
        if(!$this->id)
        return null;
        $urlPath = Storage::disk("conteudos-digitais")->path("visualizacao");
        $urlPath = $urlPath.DIRECTORY_SEPARATOR.$this->id.".*";
        $info = glob($urlPath);
        if(sizeof($info)>0)
        return $info[0];
        return null;
    }

    /**
     * obtem referencia do arquivo de imgame associada
     * da categoria do conteudo em questão
     * @param \App\Category $category
     * @return \App\Model\ApiResponser retorna json
     * @return string
     */
    public function refenciaImagemAssociada()
    {
        if(!$this->id)
        return null;
        $urlPath = Storage::disk("conteudos-digitais")->path("imagem-associada". DIRECTORY_SEPARATOR . "categorias");
        $urlPath = $urlPath.DIRECTORY_SEPARATOR.$this->id.".*";
        $info = glob($urlPath);
        if(sizeof($info)>0)
        return $info[0];
        return null;
    }

    /**
     * obtem url da imagem associada
     * @param \App\Category $category
     * @return \App\Model\ApiResponser retorna json
     * @return string
     */
    public function getImageAttribute(){
        //return $urlPath;
        $filename = basename($this->refenciaImagemAssociada());
        if($this->canal_id == 2)
        {
            return Storage::disk('conteudos-digitais')->url("imagem-associada/sinopse/".$filename);
        }
        if ($filename) {
            return Storage::disk("conteudos-digitais")->url("imagem-associada/categorias/".$filename);
        }
       
        return null;
    }

    /**
     * obtem url do video destaque da categoria
     * @param \App\Category $category
     * @return \App\Model\ApiResponser retorna json
     * @return string
     */
    public function getVideoAttribute(){
        //return $urlPath;
        $filename = basename($this->refenciaVideoDestaque());
        if($filename)
        return Storage::disk("conteudos-digitais")->url("visualizacao/".$filename);
        return null;
    }

    /**
     * canal associado à categoria de conteudo
     * @param \App\Category $category
     * @return \App\Model\ApiResponser retorna json
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function canal()
    {
        return $this->belongsTo(Canal::class, 'canal_id', 'id');
    }
}
