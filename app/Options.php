<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UserCan;

class Options extends Model
{
    
     /**
     * Variavel protegida com os campos a ser adcionado e array associativo
     * @param \App\Options $options
     * @return \App\Model\ApiResponser retorna json
     */
     
    use UserCan;

    protected $fillable = [
        'name',
        'meta_data',
    ];
       
     /**
     * Variavel protegida com os campos a ser adcionado e array associativo
     * @param \App\Options $options
     * @return \App\Model\ApiResponser retorna json
     */
    protected $appends = ['user_can'];
    
     /**
     * Variavel protegida com os campos a ser adcionado e array associativo
     * @param \App\Options $options
     * @return \App\Model\ApiResponser retorna json
     */
    protected $casts = [
        'meta_data' => 'array',
    ];
}
