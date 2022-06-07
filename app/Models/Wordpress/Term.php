<?php

namespace App\Models\Wordpress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "pw_terms";
    protected $primaryKey = 'term_id';

    
}
