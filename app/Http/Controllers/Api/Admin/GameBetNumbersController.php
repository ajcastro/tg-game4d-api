<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Queries\GameTransactionQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameBetNumbersController extends ResourceController
{
    public function __construct()
    {
        $this->hook(function () {
            $this->query = new GameTransactionQuery;
        })->only(['index']);
    }

    public function index(Request $request)
    {
        $query = $this->query->addSelect([
            'game_id',
            'game_code',
            'number',
            DB::raw('count(*) as instance_count'),
            DB::raw('sum(bet) as bet'),
            DB::raw('sum(pay) as pay'),
        ])
        ->groupBy([
            'game_id',
            'game_code',
            'number',
        ]);

        $query = $query->withAllDeclarations();

        return $this->resource()::collection($this->executeCollectionQuery($request, $query));
    }
}
