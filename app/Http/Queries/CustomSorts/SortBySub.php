<?php

namespace App\Http\Queries\CustomSorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class SortBySub implements Sort
{
    protected array $addSelect;

    protected $alias;
    protected $subQuery;

    public function __construct($alias, $subQuery)
    {
        $this->alias = $alias;
        $this->subQuery = $subQuery;
    }

    public static function make($alias, $subQuery)
    {
        return new static($alias, $subQuery);
    }

    public function __invoke(Builder $query, $descending, string $property): Builder
    {
        $query->addSelect([$this->alias => value($this->subQuery)]);

        return $query->orderBy($this->alias, $descending ? 'desc' : 'asc');
    }

}
