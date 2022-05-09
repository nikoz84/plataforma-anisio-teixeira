<?php

namespace App\Models;

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
    /**Tabela com campos definidos */
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
