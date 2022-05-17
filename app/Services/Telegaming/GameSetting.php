<?php

namespace App\Services\Telegaming;

use App\Services\Telegaming\Http\TgHttp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'win_multiplier' => 'decimal:2',
        'percentage_discount' => 'decimal:2',
        'percentage_kei' => 'decimal:2',
    ];

    public static function getSetting($website_code, $game_code): GameSetting
    {
        return remember("game_settings.{$website_code}.{$game_code}", now()->addMinutes(app()->isProduction() ? 1 : 0),
            function () use ($website_code, $game_code) {
                $attributes = TgHttp::instance()->getGameSetting($website_code, $game_code);
                return new static($attributes);
            }
        );
    }
}
