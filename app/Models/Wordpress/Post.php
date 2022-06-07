<?php

namespace App\Models\Wordpress;

use App\Models\Wordpress\User;
use App\Models\Wordpress\PostMeta;
use App\Models\Wordpress\Term;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\TransformDate;

class Post extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'pw_posts';
    protected $primaryKey = 'ID';

    public $appends = ['title', 'image', 'url_exibir', 'formated_date', 'terms'];

    public function user()
    {
        return $this->belongsTo(User::class, 'post_author', 'ID')->select(['ID', 'display_name']);
        //->with(['userMeta']);
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
        return "/blog/conteudo/exibir/{$this->getAttribute('ID')}";
    }

    public function getFormatedDateAttribute()
    {
        return TransformDate::format($this['post_date']);
    }

    public function getTermsAttribute()
    {
        $sql = "select ate.term_id, att.taxonomy, ate.name, ate.slug  from pw_posts ap 
            join pw_term_relationships atr on atr.object_id = ap.ID 
            join pw_term_taxonomy att on att.term_taxonomy_id = atr.term_taxonomy_id
            join pw_terms ate on ate.term_id = att.term_id  
            where ap.post_status = 'publish' 
            and ap.post_type = 'post' 
         and ap.ID = ?";

        $db = collect(DB::connection('mysql')->select(DB::raw($sql), [$this->ID]));

        return $db->toArray();
    }
}
