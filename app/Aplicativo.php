<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aplicativo extends Model
{
    protected $id = 'id';
    protected $fillable = [
        'name',
        'description',
        'is_featured',
        'options',
        'created_at'];

    public function getAplicativo()
    {
        return $this->belongsTo('App\Aplicativo');
    }
}
