<?php

namespace App\Models\Wordpress;

use App\Traits\WPPrefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermTaxonomy extends Model
{
    use HasFactory;use WPPrefix;

    protected $table = 'term_taxonomy';

    protected $primaryKey = 'term_taxonomy_id';

    public function __construct(array $attributes = [])
    {
        $this->table = $this->getPrefix().$this->table;

        parent::__construct($attributes);
    }

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id', 'term_id');
    }
}
