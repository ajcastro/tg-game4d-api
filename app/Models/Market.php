<?php

namespace App\Models;

use App\Models\Game;
use App\Models\MarketSchedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property MarketSchedule $marketSchedule
 */
class Market extends Model
{
    use HasFactory, Traits\HasAllowableFields;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'status',
        'flag',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function scopeSearch($query, $search)
    {
        $query->where(function ($query) use ($search) {
            $query->where('code', 'like', "%{$search}%");
            $query->orWhere('name', 'like', "%{$search}%");
        });
    }

    public function marketSchedule()
    {
        return $this->hasOne(MarketSchedule::class)->withDefault();
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function getNextPeriod()
    {
        return $this->games()
            ->value(DB::raw('max(period)')) + 1;
    }

    public function getNextDate()
    {
        return null; // TODO: implement code
    }
}
