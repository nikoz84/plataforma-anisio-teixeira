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

    public function subCategories()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id')
            ->selectRaw("id, parent_id, name")
            ->where('options->is_active', 'true');
    }

    /**
     * obtem referencia do arquivo de video destaque
     * da categoria do conteudo em questão
     * @return string
     */
    function refenciaVideoDestaque()
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
     * @return string
     */
    function refenciaImagemAssociada()
    {
        if(!$this->id)
        return null;
        $urlPath = Storage::disk("conteudos-digitais")->path("imagem-associada");
        $urlPath = $urlPath.DIRECTORY_SEPARATOR.$this->id.".*";
        $info = glob($urlPath);
        if(sizeof($info)>0)
        return $info[0]; 
        return null;
    }

    /**
     * obtem url da imagem associada
     * @return string
     */
    function getImageAttribute(){
        //return $urlPath;
        $filename = basename($this->refenciaImagemAssociada());
        return Storage::disk("conteudos-digitais")->url("imagem-associada/".$filename); 
    }

    /**
     * obtem url do video destaque da categoria
     * @return string
     */
    function getVideoAttribute(){
        //return $urlPath;
        $filename = basename($this->refenciaVideoDestaque());
        if($filename)
        return Storage::disk("conteudos-digitais")->url("visualizacao/".$filename);
        return null;
    }

    /**
     * canal associado à categoria de conteudo
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function canal()
    {
        return $this->belongsTo(Canal::class, 'canal_id', 'id');
    }
}