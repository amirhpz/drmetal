<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'is_panel_user', 'panel_role_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'is_panel_user' => 'boolean',
        ];
    }

    public function panelRole(): BelongsTo
    {
        return $this->belongsTo(PanelRole::class);
    }

    public function canAccessPanel(): bool
    {
        return $this->is_panel_user;
    }

    public function hasPanelPermission(string $permission): bool
    {
        if (! $this->canAccessPanel()) {
            return false;
        }

        if (! $this->panel_role_id) {
            return true;
        }

        $role = $this->relationLoaded('panelRole') ? $this->panelRole : $this->panelRole()->first();

        return (bool) $role?->is_active && $role->hasPermission($permission);
    }
}
