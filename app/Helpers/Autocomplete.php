<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Autocomplete
{
    protected $term;
    protected $limit;
    protected $per;

    public function __construct($term, $limit, $per)
    {
        $this->term = $term;
        $this->limit = $limit;
        $this->per = $per;
    }
    public function autocomplete()
    {
        switch ($this->per) {
            case 'titulo':
                return $this->perTitle();
                break;
            default:
                return $this->perTag();
                break;
        }
    }
    private function perTitle()
    {

        $paginator = DB::table(DB::raw("conteudos as cd, plainto_tsquery('simple', lower(unaccent(?))) query"))
            ->select([
                'cd.id', 'cd.title as name',
                DB::raw('ts_rank_cd(cd.ts_documento, query) AS ranking'),
            ])
            ->whereRaw('query @@ cd.ts_documento')
            ->whereRaw('cd.is_approved = true')
            ->setBindings([$this->term])
            ->orderBy('ranking', 'desc')
            ->paginate($this->limit);

        return $paginator->setPath("/autocompletar?termo={$this->term}&por={$this->per}&limit={$this->limit}");
    }
    private function perTag()
    {
        $search = "%{$this->term}%";

        $paginator = DB::table("tags as t")
            ->select(['t.id', 't.name'])
            ->whereRaw('unaccent(lower(t.name)) LIKE unaccent(lower(?))', [$search])
            ->orderBy('t.name', 'desc')
            ->paginate($this->limit);

        return $paginator->setPath("/autocompletar?termo={$this->term}&por={$this->per}&limit={$this->limit}");
    }
}
