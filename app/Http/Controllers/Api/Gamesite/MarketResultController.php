<?php

namespace App\Http\Controllers\Api\Gamesite;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Market;
use Illuminate\Http\Request;

class MarketResultController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $markets = Market::get();

        // TODO: FIXME: fix this query to retrieve only one game for each market, move into static helper method
        $results = Game::whereNotNull('market_result')
            ->orderBy('date')
            ->get();

        $this->assignResultsToMarkets($markets, $results);

        return $markets
            ->map
            ->only(['id', 'code',  'name', 'flag_url', 'date', 'result']);
    }

    private function assignResultsToMarkets($markets, $results)
    {
        $results = $results->keyBy('market_id');

        foreach ($markets as $market) {
            $result = $results[$market->id] ?? new Game();
            $market->date = $result->date;
            $market->result = $result->market_result;
        }
    }
}
