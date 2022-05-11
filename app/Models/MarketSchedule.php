<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketSchedule extends Model
{
    use HasFactory, Traits\HasAllowableFields;

    const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'market_id',
        'result_day',
        // 'is_result_day_everyday', computed
        // 'off_day', not fillable, auto-filled by the diff of result_day and static::DAYS
        // 'is_off_day_everyday', computed
        'close_time',
        'result_time',
        // 'updated_by_id', computed
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'market_id' => 'integer',
        'result_day' => 'json',
        'is_result_day_everyday' => 'boolean',
        'off_day' => 'json',
        'is_off_day_everyday' => 'boolean',
        'updated_by_id' => 'integer',
    ];

    public static function booted()
    {
        static::saving(function (MarketSchedule $marketSchedule) {
            $marketSchedule->updated_by_id = auth()->user()->id ?? 1;
            $marketSchedule->is_result_day_everyday = static::isEveryday($marketSchedule->result_day);
            $marketSchedule->is_off_day_everyday = static::isEveryday($marketSchedule->off_day);
        });
    }

    public static function sortDays($days)
    {
        $flippedDays = array_flip(static::DAYS);
        return collect($days)->sortBy(function ($day) use ($flippedDays) {
            return $flippedDays[$day];
        })
        ->values()
        ->all();
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function setResultDayAttribute($value)
    {
        $result_day = static::sortDays($value);
        $off_day = collect(static::DAYS)->diff($result_day)->values()->all();

        $this->attributes['result_day'] = json_encode($result_day);
        $this->attributes['off_day'] = json_encode($off_day);
    }

    public static function isEveryday($days)
    {
        return static::sortDays($days) === static::DAYS;
    }
}
