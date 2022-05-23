<?php

namespace App\Models;

use App\Observers\SetsCreatedByAndUpdatedBy;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property Role $role
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Traits\HasAllowableFields, Traits\SetActiveStatus;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'password',
        'is_active',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public static function booted()
    {
        static::observe(SetsCreatedByAndUpdatedBy::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_admin;
    }

    public function getCaslAbilities(): array
    {
        if ($this->isSuperAdmin()) {
            return [[
                'action' => 'manage',
                'subject' => 'all',
            ]];
        }

        return [
            [
                'action' => 'read',
                'subject' => 'Market',
            ],
            [
                'action' => 'read',
                'subject' => 'Game',
            ],
            [
                'action' => 'read',
                'subject' => 'GameResult',
            ],
            [
                'action' => 'read',
                'subject' => 'BetList',
            ],
        ];
    }

    public function getAdminRedirect()
    {
        return 'games/list';
    }
}
