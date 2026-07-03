<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'phone', 'role', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    /**
     * Determine if the user can access the Filament admin panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if the user is an admin.
     * Kept for backward compatibility, but now uses Spatie's hasRole.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if the user is a member.
     * Kept for backward compatibility.
     */
    public function isMember(): bool
    {
        return $this->hasRole('user');
    }

    /*
    |--------------------------------------------------------------------------
    | Membership / Subscription Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * All transactions made by the user.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * All membership records for the user.
     */
    public function userMemberships(): HasMany
    {
        return $this->hasMany(UserMembership::class);
    }

    /**
     * Get the user's currently active membership (if any).
     */
    public function activeMembership(): HasOne
    {
        return $this->hasOne(UserMembership::class)
            ->where('is_active', true)
            ->where('ends_at', '>=', now())
            ->latest('id');
    }

    /**
     * Check if the user has an active premium membership.
     */
    public function isPremium(): bool
    {
        return $this->activeMembership()->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | Reward Points Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * All reward points for the user.
     */
    public function rewardPoints(): HasMany
    {
        return $this->hasMany(RewardPoint::class);
    }

    /**
     * Get user's total approved points.
     */
    public function getTotalApprovedPointsAttribute(): int
    {
        return $this->rewardPoints()
            ->where('status', 'approved')
            ->sum('points');
    }

    /**
     * Get user's total pending points.
     */
    public function getTotalPendingPointsAttribute(): int
    {
        return $this->rewardPoints()
            ->where('status', 'pending')
            ->sum('points');
    }
}
