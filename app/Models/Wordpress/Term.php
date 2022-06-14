<?php

namespace App\Models\Wordpress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\WPPrefix;

class Term extends Model
{
    use HasFactory, WPPrefix;

    protected $connection = 'mysql';
    protected $table = "terms";
    protected $primaryKey = 'term_id';

    public function __construct(array $attributes = [])
    {
        $this->table = $this->getPrefix() . $this->table;

        parent::__construct($attributes);
    }
}
