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

    public function firstPanelRoute(): string
    {
        foreach ($this->panelRoutePermissions() as $permission => $route) {
            if ($this->hasPanelPermission($permission)) {
                return route($route);
            }
        }

        return route('home');
    }

    /**
     * @return array<string, string>
     */
    private function panelRoutePermissions(): array
    {
        return [
            'dashboard.view' => 'panel.dashboard',
            'users.manage' => 'panel.users.index',
            'roles.manage' => 'panel.roles.index',
            'posts.manage' => 'panel.posts.index',
            'post_categories.manage' => 'panel.post-categories.index',
            'clients.manage' => 'panel.clients.index',
            'quote_requests.manage' => 'panel.quote-requests.index',
            'product_categories.manage' => 'panel.product-categories.index',
            'products.manage' => 'panel.products.index',
            'settings.manage' => 'panel.settings.edit',
        ];
    }
}
