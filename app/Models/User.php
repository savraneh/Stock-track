<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, [
            UserRole::Admin,
            UserRole::Supervisor,
            UserRole::Purchasing,
        ], true);
    }

    public function isWarehouseAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isSupervisor(): bool
    {
        return $this->role === UserRole::Supervisor;
    }

    public function isPurchasing(): bool
    {
        return $this->role === UserRole::Purchasing;
    }

    public function canManageMasterData(): bool
    {
        return $this->isWarehouseAdmin();
    }

    public function canCreateTransactions(): bool
    {
        return $this->isWarehouseAdmin();
    }

    public function canViewAnalytics(): bool
    {
        return $this->isWarehouseAdmin() || $this->isSupervisor();
    }

    public function canViewRestockRecommendations(): bool
    {
        return $this->isWarehouseAdmin() || $this->isSupervisor() || $this->isPurchasing();
    }
}
