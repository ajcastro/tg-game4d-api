<?php

namespace App\Http\Queries;

use App\Http\Queries\BaseQuery;
use App\Http\Queries\Contracts\QueryContract;
use App\Http\Queries\CustomSorts\SortBySub;
use App\Models\Game;
use App\Models\Market;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class GameQuery extends BaseQuery implements QueryContract
{
    public function __construct()
    {
        parent::__construct(Game::query());
    }

    public function withFields()
    {
        $this->allowedFields([
            ...Game::allowableFields(),
            ...fields('market', Market::allowableFields()),
        ]);

        return $this;
    }

    public function withInclude()
    {
        $this->allowedIncludes([
            'market',
        ]);

        return $this;
    }

    public function withFilter()
    {
        $this->allowedFilters([
            AllowedFilter::scope('search'),
        ]);

        return $this;
    }

    public function withSort()
    {
        $this->allowedSorts([
            ...Game::allowableFields(),
            AllowedSort::custom('market_code', SortBySub::make(
                '__market_code',
                Market::query()
                ->select('code')
                ->whereColumn('games.market_id', 'markets.id')
            )),
            AllowedSort::custom('market_name', SortBySub::make(
                '__market_name',
                Market::query()
                ->select('name')
                ->whereColumn('games.market_id', 'markets.id')
            )),
        ]);

        return $this;
    }
}
