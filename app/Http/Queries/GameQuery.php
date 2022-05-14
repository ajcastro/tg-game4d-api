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
            // TODO: define fields and update admin games table request
            // 'pending_edit_date.created_by',
            // 'pending_edit_close_time.created_by',
            // 'pending_edit_market_result.created_by',
        ]);

        return $this;
    }

    public function withInclude()
    {
        $this->allowedIncludes([
            'market',
            'pending_edit_date.created_by',
            'pending_edit_close_time.created_by',
            'pending_edit_market_result.created_by',
        ]);

        return $this;
    }

    public function withFilter()
    {
        $this->allowedFilters([
            AllowedFilter::exact('period'),
            AllowedFilter::scope('search'),
            AllowedFilter::callback('market_ids', function ($query, $value) {
                $query->whereIn('market_id', $value);
            }),
            AllowedFilter::callback('open', function ($query, $value) {
                $isOpen = boolean($value);
                if ($isOpen) {
                    $query->whereNull('market_result');
                } else {
                    $query->whereNotNull('market_result');
                }
            }),
            AllowedFilter::callback('date_range', function ($query, array $value) {
                [$start_date, $end_date] = $value;
                $start_date = carbon($start_date)->startOfDay();
                $end_date = carbon($end_date)->endOfDay();
                $query->whereBetween('games.date', [$start_date, $end_date]);
            }),
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
