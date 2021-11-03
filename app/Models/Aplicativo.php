<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\TransformDate;
use App\Models\Tag;
use App\Models\AplicativoCategory;
use App\Traits\UserCan;
use App\Traits\FileSystemLogic;

class Aplicativo extends Model
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
      */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
      /**
      * Força atributo options ser um array
      */
    protected $casts = [
        'options' => 'array',
    ];
    /**
    * Relação com canal
    */
    public function canal()
    {
        Canal::$without_appends = true;

        return $this->belongsTo(Canal::class, 'canal_id')
            ->select(['id', 'name', 'slug', 'options->color as color']);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->select(['id', 'name']);
    }
    /**
     * Relação com tabela de tags
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'aplicativo_tag', 'aplicativo_id', 'tag_id')
            ->select(['id', 'name'])->orderBy('name');
    }
    /**
     * Relação com categoria
     */
    public function category()
    {
        return $this->belongsTo(AplicativoCategory::class, 'category_id', 'id');
    }

    /**
     * Descrição abreviada com 30 palavras e sem html
     */
    public function getExcerptAttribute()
    {
        return strip_tags(Str::words($this['description'], 30));
    }
    /**
     * Imagem de destaque do aplicativo
     */
    public function getImageAttribute()
    {
        return $this->getAplicativoImage($this['id']);
    }
    /**
     * Cria url exibir
     */
    public function getUrlExibirAttribute()
    {
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
     * Obtem referencia do arquivo de imgame associada
     * @return string
     */
    public function referenciaImagemAssociada()
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

    /**
     * Adiciona novo atributo ao objeto que limita o tamanho do título
     * @return string cadeia de caracteres
     */
    public function getShortTitleAttribute()
    {
        return Str::words($this->name, 8);
    }
}
