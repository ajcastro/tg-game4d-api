<?php

namespace App\Http\Controllers\Api\Gamesite;

use App\Http\Controllers\ResourceController;
use App\Http\Queries\GameTransactionQuery;
use App\Models\GameTransaction;

class GameTransactionController extends ResourceController
{
    public function __construct()
    {
        $this->hook(function () {
            $this->model = GameTransaction::class;
        });

        $this->hook(function () {
            $this->query = new GameTransactionQuery;
        })->only(['index', 'show']);
    }
}
