<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserCan;

class Newsletter extends Model
/**
 * Metodos Protegidos
 */
{
    use SoftDeletes, UserCan;
    /**Tabela com campos definidos */
    public $timestamps = false;
    protected $table = 'newsletter';
    protected $fillable = ['email', 'data'];
    /**Tabela com campo definido */
    protected $appends = ['user_can'];
}
