<?php

namespace App\Http\Queries;

use App\Http\Queries\BaseQuery;
use App\Http\Queries\Contracts\QueryContract;
use App\Http\Queries\CustomSorts\SortBySub;
use App\Models\Game;
use App\Models\GameTransaction;
use App\Models\Market;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class GameTransactionQuery extends BaseQuery implements QueryContract
{
    public function __construct()
    {
        parent::__construct(GameTransaction::query());
    }

    public function withFields()
    {
        $this->allowedFields([
            ...GameTransaction::allowableFields(),
            ...fields('game', Game::allowableFields()),
            ...fields('game.market', Market::allowableFields()),
        ]);

        return $this;
    }

    public function withInclude()
    {
        $this->allowedIncludes([
            'member',
            'game',
            'game.market',
        ]);

        return $this;
    }

    public function withFilter()
    {
        $this->allowedFilters([
            AllowedFilter::callback('game_codes', function ($query, $value) {
                $query->whereIn('game_transactions.game_code', $value);
            }),
            AllowedFilter::callback('market_ids', function ($query, $value) {
                $query->whereHas('game.market', function ($query) use ($value) {
                    $query->whereIn('markets.id', $value);
                });
            }),
        ]);

        return $this;
    }

    public function withSort()
    {
        $this->allowedSorts([
            ...GameTransaction::allowableFields(),
        ]);

        return $this;
    }
}
