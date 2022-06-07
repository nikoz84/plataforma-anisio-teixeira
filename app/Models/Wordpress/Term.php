<?php

namespace App\Models\Wordpress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Env;

class Term extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "pw_terms";
    protected $primaryKey = 'ID';

    public function post()
    {
        return $this->belongsTo(Post::class, 'ID');
    }
}
