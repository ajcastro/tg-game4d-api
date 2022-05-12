<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Queries\GameQuery;
use App\Http\Requests\Api\Admin\GameRequest;
use App\Models\Game;
use App\Models\GameEdit;
use Illuminate\Http\Resources\Json\JsonResource;

class GameController extends ResourceController
{
    public function __construct()
    {
        $this->hook(function () {
            $this->model = Game::class;
        });

        $this->hook(function () {
            $this->query = new GameQuery;
        })->only(['index', 'show']);

        $this->hook(function () {
            $this->request = GameRequest::class;
        })->only(['store', 'update']);
    }

    public function update($id)
    {
        $request = $this->request();
        /** @var Game */
        $game = $this->getRecord($id);

        $edit_fields = [
            'date', 'close_time', 'market_result'
        ];

        foreach ($edit_fields as $edit_field) {
            if ($request->input($edit_field)) {
                $game->makeGameEdit($edit_field, $request->input($edit_field))
                    ->save();
            }
        }

        return new JsonResource($game);
    }

    public function approveGameEdit(Game $game, GameEdit $gameEdit)
    {
        $game->applyGameEdit($gameEdit);
    }
}
