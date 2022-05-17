<?php

namespace App\Http\Controllers\Api\Gamesite;

use App\Http\Controllers\ResourceController;
use App\Http\Queries\GameQuery;
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
    }
}
