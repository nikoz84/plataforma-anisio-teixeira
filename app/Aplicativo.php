<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conteudo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\TransformDate;
use App\Tag;
use App\AplicativoCategory;
use App\Traits\UserCan;
use Illuminate\Support\Facades\File;
use App\Traits\FileSystemLogic;

class Aplicativo extends Conteudo
{
    use SoftDeletes, UserCan, FileSystemLogic;

    const CANAL_ID = 9;
    const QT_ACCESS_INIT = 0;

    /**
     * Cria a tabela aplicativo no Bancode dados Protegida
     * @param \App\Aplicativo $aplicativo
     * @return \App\Model\ApiResponser retorna json
     */
    protected $table = 'aplicativos';
     /**
      * Tabela com os campos definidos
      * @param \App\Aplicativo $aplicativo
      * @return \App\Model\ApiResponser retorna json
      */
    protected $fillable = [
        'name',
        'user_id',
        'canal_id',
        'category_id',
        'description',
        'url',
        'is_featured',
        'options'
    ];
      
      /**
      * Tabela com os campos definidos
      * @param \App\Aplicativo $aplicativo
      * @return \App\Model\ApiResponser retorna json
      */
    protected $appends = [
        'image',
        'excerpt',
        'url_exibir',
        'formated_date',
        'user_can'
    ];
      /**
      * Tabela com os campos definidos
      * @param \App\Aplicativo $aplicativo
      * @return \App\Model\ApiResponser retorna json
      */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
      /**
      * Tabela com os campos definidos
      * @param \App\Aplicativo $aplicativo
      * @return \App\Model\ApiResponser retorna json
      */
    protected $casts = [
        'options' => 'array',
    ];
       /**
      * Método canal 
      * 
      * @param \App\Aplicativo $aplicativo
      * @return \App\Model\ApiResponser retorna json
      */
    public function canal()
    {
        Canal::$without_appends = true;

        return $this->belongsTo(Canal::class, 'canal_id')
            ->select(['id', 'name', 'slug', 'options->color as color'])
            ->where('id', 9);
    }
    /**
     * Conjunto de tags do aplicativo
     * @param \App\Aplicativo $aplicativo
     * @return \App\Model\ApiResponser retorna json
     * 
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'aplicativo_tag', 'aplicativo_id', 'tag_id')
            ->select(['id', 'name'])->orderBy('name');
    }
    /**
     * Conjunto de categorias do aplicativo
     * @param \App\Aplicativo $aplicativo
     * @return \App\Model\ApiResponser retorna json
     *  
     */
    public function category()
    {
        return $this->belongsTo(AplicativoCategory::class, 'category_id', 'id');
    }

    /**
     * Descrição abreviada
     * @param \App\Aplicativo $aplicativo
     * @return \App\Model\ApiResponser retorna json
     * 
     */
    public function getExcerptAttribute()
    {
        return strip_tags(Str::words($this['description'], 30));
    }
    /**
     * Imagem de destaque do aplicativo
     * 
     * @param \App\Aplicativo $aplicativo
     * @return \App\Model\ApiResponser retorna json
     */
    public function getImageAttribute()
    {
        return $this->getAplicativoImage($this['id']);
    }
    /**
     * Cria url exibir
     * @param \App\Aplicativo $aplicativo
     * @return \App\Model\ApiResponser retorna json
     * 
     */
    public function getUrlExibirAttribute()
    {
        //$slug = $this->canal()->pluck('slug')->first();

        return "/aplicativos-educacionais/aplicativo/exibir/" . $this['id'];
    }
    /**
     * Seleciona e tranforma created-at ao formato (06 setembro de 2019 ás 17:37)
     * @param \App\Aplicativo $aplicativo
     * @return \App\Model\ApiResponser retorna json
     */
    public function getFormatedDateAttribute()
    {
        return TransformDate::format($this['created_at']);
    }

    /**
     * obtem referencia do arquivo de imgame associada
     * @param \App\Aplicativo $aplicativo
     * @return \App\Model\ApiResponser retorna json
     * @return string
     */
<<<<<<< HEAD
     public function refenciaImagemAssociada()
=======
    public function refenciaImagemAssociada()
>>>>>>> 59fafea095472a7b96e5e8137d18ca03da6dc9ba
    {
        if (!$this->id) {
            return null;
        }
        
        $urlPath = Storage::disk("aplicativos-educacionais")->path("imagem-associada");
        $urlPath = $urlPath.DIRECTORY_SEPARATOR.$this->id.".*";
        $info = glob($urlPath);
        if (sizeof($info)>0) {
            return $info[0];
        }
        
        return null;
    }
    
}
