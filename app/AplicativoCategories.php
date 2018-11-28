<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AplicativoCategories extends Model
{
    public function categories()
    {
        return $this->belongsTo('App\Aplicativo', 'category_id');
    }
}
