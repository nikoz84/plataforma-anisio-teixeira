<?php

namespace App\Models\Wordpress;

use App\Models\Wordpress\User;
use App\Models\Wordpress\PostMeta;
use App\Models\Wordpress\Term;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\TransformDate;
use App\Models\Wordpress\TermTaxonomy;

class Post extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'pw_posts';
    protected $primaryKey = 'ID';

    public $appends = ['title', 'image', 'url_exibir', 'formated_date', 'tags', 'categories'];

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

    public function terms()
    {

        return $this->belongsToMany(TermTaxonomy::class, 'pw_term_relationships', 'object_id', 'term_taxonomy_id')->with('term');
    }

    public function getTagsAttribute()
    {
        $terms = $this->terms()->get();
        
        return $this->mapTerms($terms, 'post_tag');
    }

    public function getCategoriesAttribute()
    {
        $terms = $this->terms()->get();
        
        return $this->mapTerms($terms, 'category');
    }

    protected function mapTerms($items, $type)
    {
        return $items->map(function($item) use ($type) {
            if($item->taxonomy === $type){
                return [
                    'id' => $item->term_id,
                    'taxonomy' => $item->taxonomy,
                    'name' => $item->term->name,
                    'term_id' => $item->term->term_id,
                    'slug' => $item->term->slug,
                ];
            }
        })->whereNotNull();
    }

    public function getUrlExibirAttribute()
    {
        return "/blog/conteudo/exibir/{$this->getAttribute('ID')}";
    }

    public function getFormatedDateAttribute()
    {
        return TransformDate::format($this['post_date']);
    }

    
}
