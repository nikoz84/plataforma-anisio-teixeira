<?php

namespace App\Models\Wordpress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'at_postmeta';
    protected $primaryKey = 'meta_id';
}
