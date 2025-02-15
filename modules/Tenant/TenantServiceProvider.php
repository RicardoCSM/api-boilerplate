<?php

declare(strict_types=1);

namespace Modules\Tenant;

use Illuminate\Support\ServiceProvider;
use Modules\Tenant\Commands\ForgetCachedPermissions;

class TenantServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ForgetCachedPermissions::class);
    }

    public function boot(): void
    {
        $this->commands([
            ForgetCachedPermissions::class,
        ]);
    }
}
