<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'market_id',
        'market_period',
        'period',
        'close_time',
        'result_time',
        'market_result',
        'result_day',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'market_id' => 'integer',
        'market_period' => 'date',
        'period' => 'integer',
        'close_time' => 'timestamp',
        'result_time' => 'timestamp',
        'result_day' => 'integer',
    ];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public static function from(Market $market, array $attributes = []): static
    {
        return new static($attributes + [
            'market_id' => $market->id,
            'period' => static::getNextPeriod($market->market->code),
            'close_time' => $market->marketSchedule->close_time,
            'result_time' => $market->marketSchedule->result_time,
            'market_result' => null,
        ]);
    }

    public static function getNextPeriod($market_code)
    {
        return static::where('market_code', $market_code)
            ->value(DB::raw('max(period)')) + 1;
    }
}
