<?php

namespace App\Services\Telegaming\Http;

use Illuminate\Http\Client\PendingRequest;

class TgHttp
{
    protected PendingRequest $http;

    public function __construct(PendingRequest $http)
    {
        $this->http = $http;
    }

    public static function instance(): TgHttp
    {
        return TgHttpFactory::instance();
    }

    public function getGameSetting($website_code, $game_code)
    {
        return $this->http->get('api/v1/game_setting', [
            'website_code' => $website_code,
            'game_code' => $game_code,
        ])
        ->json();
    }
}
