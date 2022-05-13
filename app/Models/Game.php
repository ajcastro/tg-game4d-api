<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property Market $market
 */
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

    public static function from(Market $market, array $attributes = []): static
    {
        return new static($attributes + [
            'market_id' => $market->id,
            'period' => $attributes['period'] ?? $market->getNextPeriod(),
            'date' => $attributes['date'] ?? $market->getNextDate(),
            'close_time' => $market->marketSchedule->close_time,
            'result_time' => $market->marketSchedule->result_time,
            'market_result' => null,
        ]);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function pendingEditDate()
    {
        return $this->hasOne(GameEdit::class)
            ->where('edit_field', 'date')
            ->whereNull('approved_by_id');
    }

    public function pendingEditCloseTime()
    {
        return $this->hasOne(GameEdit::class)
            ->where('edit_field', 'close_time')
            ->whereNull('approved_by_id');
    }

    public function pendingEditMarketResult()
    {
        return $this->hasOne(GameEdit::class)
            ->where('edit_field', 'market_result')
            ->whereNull('approved_by_id');
    }

    public function pendingGameEdits()
    {
        return $this->hasMany(GameEdit::class)
            ->whereNull('approved_by_id');
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

    public function makeGameEdit($edit_field, $value)
    {
        return new GameEdit([
            'game_id' => $this->id,
            'edit_field' => $edit_field,
            $edit_field => $value,
            'created_by_id' => auth()->user()->id ?? 0,
        ]);
    }

    public function hasExistingGameEdit($edit_field)
    {
        return $this->pendingGameEdits()->where('edit_field', $edit_field)->count() > 0;
    }

    public function approveGameEdit(GameEdit $gameEdit)
    {
        $field = $gameEdit->edit_field;
        $this->{$field} = $gameEdit->{$field};
        $this->save();

        $gameEdit->setApproval('approve')
            ->save();

        if ($field === 'market_result') {
            Game::from($gameEdit->game->market)
                ->save();
        }
    }

    public function rejectGameEdit(GameEdit $gameEdit)
    {
        $gameEdit->setApproval('reject')
            ->save();
    }
}
