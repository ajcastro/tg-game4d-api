<?php

namespace App\Http\Queries\CustomSorts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Sorts\Sort;

class SortByRaw implements Sort
{
    protected array $addSelect;

    protected $alias;
    protected $raw;

    public function __construct($alias, $raw)
    {
        $this->alias = $alias;
        $this->raw = $raw;
    }

    public static function make($alias, $raw)
    {
        return new static($alias, $raw);
    }

    public function __invoke(Builder $query, $descending, string $property): Builder
    {
        if (empty($query->getQuery()->columns)) {
            $query->select([$query->getQuery()->from.'.*']);
        }

        $query->addSelect([
            DB::raw($this->raw.' as '.$this->alias),
        ]);

        return $query->orderBy($this->alias, $descending ? 'desc' : 'asc');
    }

}
