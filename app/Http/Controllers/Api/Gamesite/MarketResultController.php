<?php

namespace App\Http\Controllers\Api\Gamesite;

use App\Http\Controllers\Controller;
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

        $showFull = $request->boolean('show_full', false);

        $this->assignLatestGameResultToMarkets($markets, $showFull);

        if ($showFull) {
            return $markets;
        }

        return $markets
                ->map
                ->only(['id', 'code',  'name', 'flag_url', 'date', 'result']);
    }

    private function assignLatestGameResultToMarkets($markets, $setLatestGame = false)
    {
        foreach ($markets as $market) {
            /** @var Market $market */
            $latestGame = $market->findLatestGame() ?? optional();

            $market->date = $latestGame->date;
            $market->result = $latestGame->market_result;

            if ($setLatestGame) {
                $market->setRelation('latest_game', $latestGame);
            }
        }
    }
}
