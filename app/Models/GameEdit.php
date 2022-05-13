<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Game $game
 */
class GameEdit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'edit_field',
        'date',
        'close_time',
        'market_result',
        'created_by_id',
        'approved_by_id',
        'action',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'game_id' => 'integer',
        'date' => 'date:Y-m-d',
        'created_by_id' => 'integer',
        'approved_by_id' => 'integer',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function setApproval($action)
    {
        $this->approved_by_id = auth()->user()->id ?? 0;
        $this->action = $action;

        return $this;
    }
}
