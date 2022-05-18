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

    public function getGameSettings($website_code, array $game_codes = [])
    {
        return $this->http->get('api/v1/game_settings', [
            'filter' => array_filter([
                'website_code' => $website_code,
                'game_codes' => collect($game_codes)->implode(','),
            ]),
            'include' => 'game',
            'paginate' => false,
        ])
        ->throw()
        ->json('data');
    }
}
