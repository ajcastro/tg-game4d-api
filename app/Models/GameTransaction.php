<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder winnerFor($game, $game_code, array $result)
 * @method static \Illuminate\Database\Eloquent\Builder loserFor($game, $game_code, array $result)
 */
class GameTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'member_id',
        'game_code',
        'num1',
        'num2',
        'num3',
        'num4',
        'bet',
        'discount',
        'pay',
        'game_setting',
        'status',
        'winning_amount',
        'credit_amount',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'game_id' => 'integer',
        'member_id' => 'integer',
        'num1' => 'integer',
        'num2' => 'integer',
        'num3' => 'integer',
        'num4' => 'integer',
        'bet' => 'decimal:2',
        'discount' => 'decimal:2',
        'pay' => 'decimal:2',
        'game_setting' => 'object',
        'status' => 'integer',
        'winning_amount' => 'decimal:2',
        'credit_amount' => 'decimal:2',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeWinnerFor($query, Game $game, $game_code, array $result)
    {
        $query
            ->where('game_id', $game->id)
            ->where('game_code', $game_code)
            ->where($result);
    }

    public function scopeLoserFor($query, Game $game, $game_code, array $result)
    {
        $query
            ->where('game_id', $game->id)
            ->where('game_code', $game_code)
            ->where(function ($query) use ($result) {
                foreach ($result as $numKey => $value) {
                    $query->where($numKey, '!=', $value);
                }
            });
    }

    public function getGameSetting($key)
    {
        return $this->game_setting->{$key};
    }

    public function computeWinningAmount()
    {
        return $this->bet * ($this->getGameSetting('win_multiplier')/100);
    }
}
