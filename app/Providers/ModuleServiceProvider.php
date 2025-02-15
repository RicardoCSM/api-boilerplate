<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Tenant\Middleware\InitializeTenancyByRequestData;

final class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerProviders();
    }

    public function boot(): void
    {
        $this->configureV1Routes();
    }

    private function registerProviders(): void
    {
        $this->app->register(\Modules\Auth\AuthServiceProvider::class);
        $this->app->register(\Modules\Common\CommonServiceProvider::class);
        $this->app->register(\Modules\Tenant\TenantServiceProvider::class);
    }

    private function configureV1Routes(): void
    {
        $modules = config('modules');

        foreach ($modules as $key => $module) {
            if (is_string($module)) {
                $this->routesWithoutSubmodules($module, 'v1');
            }

            if (is_array($module)) {
                foreach ($module as $submodule) {
                    $this->routesWithSubmodules($key, $submodule, 'v1');
                }
            }
        }
    }

    private function routesWithoutSubmodules(
        string $module,
        string $version = 'v1'
    ): void {
        Route::prefix("api/{$version}")
            ->middleware(['tenant', 'api', InitializeTenancyByRequestData::class])
            ->namespace("Modules\\{$module}\\Controllers")
            ->group(base_path("modules/{$module}/Routes/v1.php"));
    }

    private function routesWithSubmodules(
        string $module,
        string $submodule,
        string $version = 'v1'
    ): void {
        Route::prefix("api/{$version}")
            ->middleware(['tenant', 'api', InitializeTenancyByRequestData::class])
            ->namespace("Modules\\{$module}\\{$submodule}\\Controllers")
            ->group(base_path("modules/{$module}/{$submodule}/Routes/v1.php"));
    }
}
