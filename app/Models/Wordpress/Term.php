<?php

namespace App\Models\Wordpress;

use App\Traits\WPPrefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;use WPPrefix;

    protected $connection = 'mysql';

    protected $table = 'terms';

    protected $primaryKey = 'term_id';

    public function __construct(array $attributes = [])
    {
        $this->table = $this->getPrefix().$this->table;

        parent::__construct($attributes);
    }
}
