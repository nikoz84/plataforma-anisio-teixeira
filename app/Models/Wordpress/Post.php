<?php

namespace App\Models\Wordpress;

use App\Models\Wordpress\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'pw_posts';



    public function user()
    {
        return $this->belongsTo(User::class, 'post_author', 'ID')->select(['ID', 'display_name']);//->with(['userMeta']);
    }
}
