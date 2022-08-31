<?php

namespace App\Models;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class License extends Model
{
    use UserCan;

    /**
     * The attributes that are mass assignable.
     * Os Atributos podem ser atribuídos em massa
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'site', 'parent_id',
    ];

    protected $appends = ['user_can', 'image', 'has_children'];

    /**
     * Função Pertence a Conteudo
     *
     * @param  \App\License  $license
     * @return \App\Model\ApiResponser retorna json
     */
    public function conteudo()
    {
        return $this->belongsTo(Conteudo::class, 'license_id');
    }

    /**
     * Tabela autorelacionada, sub categoria
     *
     * @param  \App\Licence  $license
     * @return \App\Model\ApiResponser retorna json
     */
    public function childs()
    {
        return $this->hasMany(\App\Models\License::class, 'parent_id', 'id');
    }

    /**
     * Função Mãe Tem um
     *
     * @param  \App\Licence  $license
     * @return \App\Model\ApiResponser retorna json
     */
    public function parent()
    {
        return $this->hasOne(\App\Models\License::class, 'id', 'parent_id');
    }

    /**
     * obtem url da imagem associada
     *
     * @return string
     */
    public function image(): Attribute
    {
        $get = function () {
            $filename = basename($this->refenciaImagemAssociada());
            if ($filename) {
                return Storage::disk('conteudos-digitais')->url('imagem-associada/licencas/'.$filename);
            }

            return;
        };

        return new Attribute(
            get: $get
        );
    }

    /**
     * obtem referencia do arquivo de imgame associada
     * da categoria do conteudo em questão
     *
     * @return string
     */
    public function refenciaImagemAssociada()
    {
        if (! $this->id) {
            return;
        }

        $urlPath = Storage::disk('conteudos-digitais')->path('imagem-associada'.DIRECTORY_SEPARATOR.'licencas');
        $urlPath = $urlPath.DIRECTORY_SEPARATOR.$this->id.'.*';
        $info = glob($urlPath);
        if (count($info) > 0) {
            return $info[0];
        }

        return;
    }

    public function hasChildren(): Attribute
    {
        $get = function () {
            $count = $this->childs()->count();
            if ($count) {
                return $count ? true : false;
            }

            return;
        };

        return new Attribute(
            get: $get
        );
    }
}
