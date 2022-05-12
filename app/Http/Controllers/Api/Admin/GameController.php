<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Queries\GameQuery;
use App\Http\Requests\Api\Admin\GameRequest;
use App\Models\Game;

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
}
