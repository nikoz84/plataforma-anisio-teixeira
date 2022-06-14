<?php

namespace App\Models\Wordpress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Wordpress\Term;

use App\Traits\WPPrefix;

class TermTaxonomy extends Model
{
    use HasFactory, WPPrefix;

    protected $table =  "term_taxonomy";
    protected $primaryKey = 'term_taxonomy_id';


    public function __construct(array $attributes = [])
    {
        $this->table = $this->getPrefix() . $this->table;

        parent::__construct($attributes);
    }


    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id', 'term_id');
    }
}
