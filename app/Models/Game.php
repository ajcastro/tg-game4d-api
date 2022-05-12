<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    use HasFactory, Traits\HasAllowableFields;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'market_id',
        'date',
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
        'date' => 'date',
        'period' => 'integer',
        'result_day' => 'integer',
    ];

    public static function booted()
    {
        static::saving(function (Game $game) {
            $game->result_day = $game->date->dayOfWeek;
        });
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public static function from(Market $market, array $attributes = []): static
    {
        return new static($attributes + [
            'market_id' => $market->id,
            'period' => static::getNextPeriod($market),
            'close_time' => $market->marketSchedule->close_time,
            'result_time' => $market->marketSchedule->result_time,
            'market_result' => null,
        ]);
    }

    public static function getNextPeriod(Market $market)
    {
        return static::where('market_id', $market->id)
            ->value(DB::raw('max(period)')) + 1;
    }

    public function scopeSearch($query, $search)
    {
        $query->whereHas('market', function ($query) use ($search) {
            $query->where('markets.code', 'like', "%{$search}%");
            $query->orWhere('markets.name', 'like', "%{$search}%");
        });
    }

    public function getResultDayTextAttribute()
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return $days[$this->result_day] ?? '';
    }
}
