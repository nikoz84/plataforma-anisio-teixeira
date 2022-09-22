<?php

namespace App\Models;

use App\Helpers\TransformDate;
use App\Traits\FileSystemLogic;
use App\Traits\UserCan;
use App\Traits\ShortTitle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Aplicativo extends Model
{
    use SoftDeletes, UserCan, FileSystemLogic;

    public const CANAL_ID = 9;

    public const QT_ACCESS_INIT = 0;

    /**
     * Cria a tabela aplicativo no Banco de dados Protegida
     *
     * @param  \App\Aplicativo  $aplicativo
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
        'options',
    ];

    /**
     * Tabela com os campos definidos
     */
    protected $appends = [
        'image',
        'excerpt',
        'url_exibir',
        'formated_date',
        'user_can',
        'short_title'
    ];

    /**
     * Tabela com os campos definidos
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
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
    public function excerpt(): Attribute
    {
        return new Attribute(
            get: fn () => strip_tags(Str::words($this['description'], 30))
        );
    }

    /**
     * Imagem de destaque do aplicativo
     */
    public function image(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getAplicativoImage($this['id'])
        );
    }

    /**
     * Cria url exibir
     */
    public function urlExibir(): Attribute
    {
        return new Attribute(
            get: fn () => '/aplicativos-educacionais/aplicativo/exibir/'.$this['id']
        );
    }

    /**
     * Seleciona e tranforma created-at ao formato (06 setembro de 2019 ás 17:37)
     *
     * @param  \App\Aplicativo  $aplicativo
     * @return \App\Model\ApiResponser retorna json
     */
    public function formatedDate(): Attribute
    {
        return new Attribute(
            get: fn () => TransformDate::format($this['created_at'])
        );
    }

    /**
     * Obtem referencia do arquivo de imgame associada
     *
     * @return string
     */
    public function referenciaImagemAssociada()
    {
        if (! $this->id) {
            return;
        }

        $urlPath = Storage::disk('aplicativos-educacionais')->path('imagem-associada');
        $urlPath = $urlPath.DIRECTORY_SEPARATOR.$this->id.'.*';
        $info = glob($urlPath);
        if (count($info) > 0) {
            return $info[0];
        }

        return;
    }

    public function shortTitle(): Attribute
    {
        return new Attribute(
            get: fn () => Str::words($this->name, 12, '...')
        );
    }

    public function title(): Attribute
    {
        return new Attribute(
            get: fn () => $this->name
        );
    }
}