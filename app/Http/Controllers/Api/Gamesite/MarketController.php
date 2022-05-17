<?php

namespace App\Http\Controllers\Api\Gamesite;

use App\Http\Controllers\ResourceController;
use App\Http\Queries\MarketQuery;
use App\Models\Market;

class MarketController extends ResourceController
{
    public function __construct()
    {
        $this->hook(function () {
            $this->model = Market::class;
        });

        $this->hook(function () {
            $this->query = new MarketQuery;
        })->only(['index', 'show']);
    }
}
