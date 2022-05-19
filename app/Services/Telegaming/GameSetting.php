<?php

namespace App\Services\Telegaming;

use App\Services\Telegaming\Http\TgHttp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class GameSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'website_code',
        'game_code',
        'min_bet',
        'max_bet',
        'win_multiplier',
        'percentage_discount',
        'percentage_kei',
        'limit',
        'limit_total',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'win_multiplier' => 'integer',
        'percentage_discount' => 'integer',
        'percentage_kei' => 'integer',
    ];

    public static function getGameSettings($website_code, array $game_codes): Collection
    {
        $game_codes_key = collect($game_codes)->implode('.');

        return remember("game_settings.{$website_code}.{$game_codes_key}", now()->addMinutes(app()->isProduction() ? 1 : 0),
            function () use ($website_code, $game_codes) {
                $items = TgHttp::instance()->getGameSettings($website_code, $game_codes);
                return collect($items)
                    ->map(function ($item) {
                        $item = Arr::prepend($item, $item['game']['code'], 'game_code');
                        return new GameSetting($item);
                    });
            }
        );
    }

    public static function getGameSettingsFor4D3D2D($website_code): Collection
    {
        return static::getGameSettings($website_code, ['4D', '3D', '2D', '2DT', '2DD']);
    }
}
