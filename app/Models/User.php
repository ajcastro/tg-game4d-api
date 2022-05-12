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
        return true; // TODO: implement later
    }

    public function getCaslAbilities(): array
    {
        if ($this->isSuperAdmin()) {
            return [[
                'action' => 'manage',
                'subject' => 'all',
            ]];
        }

        $role = $this->role;

        if (is_null($role)) {
            return [];
        }

        return $role->getCaslAbilities();
    }

    public function getAdminRedirect()
    {
        if ($this->isSuperAdmin()) {
            return '/users';
        }

        $role = $this->role;
        return $role->getFirstMenuPermission()?->admin_redirect;
    }
}
