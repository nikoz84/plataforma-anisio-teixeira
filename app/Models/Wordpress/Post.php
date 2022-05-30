<?php

namespace App\Models\Wordpress;

use App\Models\Wordpress\User;
use App\Models\Wordpress\PostMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'at_posts';
    protected $primaryKey = 'ID';

    public $appends = ['title', 'image', 'url_exibir'];

    public function user()
    {
        return $this->belongsTo(User::class, 'post_author', 'ID')->select(['ID', 'display_name']); //->with(['userMeta']);
    }

    public function getImageAttribute()
    {

        $id = PostMeta::where('meta_key', '=', '_thumbnail_id')
            ->where('post_id', $this->getAttribute('ID'))
            ->get(['meta_value'])->pluck('meta_value')->first();

        return Post::select(['guid'])->whereIn('ID', [$id])->get()->pluck('guid')->first();
    }

    public function getTitleAttribute()
    {
        return $this['post_title'];
    }

    public function getUrlExibirAttribute()
    {
        return "/blog/postagem/exibir/{$this->getAttribute('ID')}";
    }
}
