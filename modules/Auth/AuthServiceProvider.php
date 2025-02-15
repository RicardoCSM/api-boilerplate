<?php

declare(strict_types=1);

namespace Modules\Auth;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Models\User;
use Modules\Auth\Support\ImpersonateManager;

final class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImpersonateManager::class);
        $this->app->alias(ImpersonateManager::class, 'impersonate');
    }

    public function boot(): void
    {
        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }
        });
    }
}
