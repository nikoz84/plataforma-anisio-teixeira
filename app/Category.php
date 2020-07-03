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
    protected $appends = ['user_can'];

    public function subCategories()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id')
            ->selectRaw("id, parent_id, name")
            ->where('options->is_active', 'true');
    }
    /**
     * Atributo de imagem
     */
    public function getImageAttribute()
    {
        $urlPath = Storage::disk("conteudos-digitais")->path("imagem-associada");
        $urlPath = $urlPath.DIRECTORY_SEPARATOR.$this->id.".*";
        $fileRef = glob($urlPath)[0];
        $filename = basename($fileRef);
        //return $urlPath;
        return Storage::disk("conteudos-digitais")->url("imagem-associada/".$filename);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function canal()
    {
        return $this->belongsTo(Canal::class, 'canal_id', 'id');
    }
}
