<?php

namespace App\Http\Controllers\Api\Gamesite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Gamesite\GameTransactionStoreRequest;
use App\Models\Game;
use App\Models\GameTransaction;
use Illuminate\Http\Request;

class GameTransactionStoreController extends Controller
{
    public function __invoke(GameTransactionStoreRequest $request)
    {
        $rows = $request->collect('rows');

        // TODO: validate member credits if sufficient

        $rows->map(function ($row) use ($request) {
            $gameTransaction = new GameTransaction(
                [
                    'game_id' => $request->game_id,
                    'member_id' => $request->user()->id,
                    'game_setting' => $row['gameSetting'],
                ]+$row
            );
            $gameTransaction->save();
            return $gameTransaction;
        });
    }
}
