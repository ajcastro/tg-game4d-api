<?php

namespace App\Http\Queries;

use App\Http\Queries\BaseQuery;
use App\Http\Queries\Contracts\QueryContract;
use App\Http\Queries\CustomSorts\SortBySub;
use App\Models\Market;
use App\Models\MarketSchedule;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class MarketQuery extends BaseQuery implements QueryContract
{
    public function __construct()
    {
        parent::__construct(Market::query());
    }

    public function withFields()
    {
        $this->allowedFields([
            ...Market::allowableFields(),
            ...fields('market_schedule', MarketSchedule::allowableFields()),
        ]);

        return $this;
    }

    public function withInclude()
    {
        $this->allowedIncludes([
            'market_schedule',
            'current_game',
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
            ...Market::allowableFields(),
            AllowedSort::custom('close_time', SortBySub::make(
                '__close_time',
                MarketSchedule::query()
                ->select('close_time')
                ->whereColumn('markets.id', 'market_schedules.market_id')
            )),
            AllowedSort::custom('result_time', SortBySub::make(
                '__result_time',
                MarketSchedule::query()
                ->select('result_time')
                ->whereColumn('markets.id', 'market_schedules.market_id')
            )),
        ]);

        return $this;
    }
}
