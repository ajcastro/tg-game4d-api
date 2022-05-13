<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Queries\GameQuery;
use App\Http\Requests\Api\Admin\GameRequest;
use App\Models\Game;
use App\Models\GameEdit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;

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
                if ($game->hasExistingGameEdit($edit_field)) {
                    throw ValidationException::withMessages([
                        $edit_field => ["There is already a pending edit request for {$edit_field}."]
                    ]);
                }

                $game->makeGameEdit($edit_field, $request->input($edit_field))
                    ->save();
            }
        }

        return new JsonResource($game);
    }

    public function approveGameEdit(Game $game, GameEdit $gameEdit, Request $request)
    {
        if ($gameEdit->created_by_id === auth()->user()->id) {
            throw ValidationException::withMessages([$gameEdit->edit_field => ['Cannot approve by the same user who edit.']]);
        }

        $action = $request->input('action', 'approve');

        if ($action === 'approve') {
            $game->approveGameEdit($gameEdit);
        }

        if ($action === 'reject') {
            $game->rejectGameEdit($gameEdit);
        }
    }
}
