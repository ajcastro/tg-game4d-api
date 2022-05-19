<?php

namespace App\Services\Telegaming\Http;

use Illuminate\Support\Facades\Http;

class TgHttpFactory
{
    protected static TgHttp $http;

    public static function baseUrl()
    {
        return config('services.tg_api.url');
    }

    public static function instance(): TgHttp
    {
        return static::$http ?? static::$http = static::make();
    }

    public static function make(): TgHttp
    {
        $http = Http::withHeaders(['Accept' => 'application/json'])
            ->baseUrl(static::baseUrl());

        return new TgHttp($http);
    }
}
