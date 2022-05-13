<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Queries\MarketQuery;
use App\Http\Requests\Api\Admin\MarketRequest;
use App\Http\Requests\Api\Admin\MarketScheduleRequest;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

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

        $this->hook(function () {
            $this->request = MarketRequest::class;
        })->only(['store', 'update']);
    }

    protected function fill($market, $request)
    {
        parent::fill($market, $request);

        /** @var UploadedFile */
        $uploadedFile = $request->file('flag');
        if ($uploadedFile) {
            $market->flag = $uploadedFile->store("market_flags");
        }
    }

    public function getMarketSchedule(Market $market)
    {
        return $market->marketSchedule;
    }

    public function setMarketSchedule(Market $market, MarketScheduleRequest $request)
    {
        $market->marketSchedule->fill($request->validated())->save();
    }

    public function setOnlineStatus(Market $market, Request $request)
    {
        $request->validate([
            'status' => [
                'required',
                'in:online,offline',
            ],
        ]);

        $market->status = $request->status;
        $market->save();
    }
}
