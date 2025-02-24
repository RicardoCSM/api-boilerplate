<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Support\ServiceProvider;
use Stancl\JobPipeline\JobPipeline;
use Stancl\Tenancy\Actions\CloneRoutesAsTenant;
use Stancl\Tenancy\Events;
use Stancl\Tenancy\Jobs;
use Stancl\Tenancy\Listeners;
use Stancl\Tenancy\Middleware;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;
use Stancl\Tenancy\Overrides\TenancyUrlGenerator;
use Stancl\Tenancy\ResourceSyncing;

class TenancyServiceProvider extends ServiceProvider
{
    // By default, no namespace is used to support the callable array syntax.
    public static string $controllerNamespace = '';

    public function events()
    {
        return [
            // Tenant events
            Events\CreatingTenant::class => [],
            Events\TenantCreated::class => [
                JobPipeline::make([
                    Jobs\CreateDatabase::class,
                    Jobs\MigrateDatabase::class,
                    Jobs\SeedDatabase::class,
                    // Jobs\CreateStorageSymlinks::class,

                    // Your own jobs to prepare the tenant.
                    // Provision API keys, create S3 buckets, anything you want!
                    // \Modules\Tenant\Jobs\CreateTenantBucket::class,
                ])->send(fn (Events\TenantCreated $event) => $event->tenant)->shouldBeQueued(false), // `false` by default, but you likely want to make this `true` in production.

                // Listeners\CreateTenantStorage::class,
            ],
            Events\SavingTenant::class => [],
            Events\TenantSaved::class => [],
            Events\UpdatingTenant::class => [],
            Events\TenantUpdated::class => [],
            Events\DeletingTenant::class => [
                JobPipeline::make([
                    Jobs\DeleteDomains::class,
                ])->send(fn (Events\DeletingTenant $event) => $event->tenant)->shouldBeQueued(false),

                // Listeners\DeleteTenantStorage::class,
            ],
            Events\TenantDeleted::class => [
                JobPipeline::make([
                    Jobs\DeleteDatabase::class,
                    // Jobs\RemoveStorageSymlinks::class,
                ])->send(fn (Events\TenantDeleted $event) => $event->tenant)->shouldBeQueued(false), // `false` by default, but you probably want to make this `true` for production.
            ],

            Events\TenantMaintenanceModeEnabled::class => [],
            Events\TenantMaintenanceModeDisabled::class => [],

            // Pending tenant events
            Events\CreatingPendingTenant::class => [],
            Events\PendingTenantCreated::class => [],
            Events\PullingPendingTenant::class => [],
            Events\PendingTenantPulled::class => [],

            // Domain events
            Events\CreatingDomain::class => [],
            Events\DomainCreated::class => [],
            Events\SavingDomain::class => [],
            Events\DomainSaved::class => [],
            Events\UpdatingDomain::class => [],
            Events\DomainUpdated::class => [],
            Events\DeletingDomain::class => [],
            Events\DomainDeleted::class => [],

            // Database events
            Events\DatabaseCreated::class => [],
            Events\DatabaseMigrated::class => [],
            Events\DatabaseSeeded::class => [],
            Events\DatabaseRolledBack::class => [],
            Events\DatabaseDeleted::class => [],

            // Tenancy events
            Events\InitializingTenancy::class => [],
            Events\TenancyInitialized::class => [
                Listeners\BootstrapTenancy::class,
            ],

            Events\EndingTenancy::class => [],
            Events\TenancyEnded::class => [
                Listeners\RevertToCentralContext::class,
            ],

            Events\BootstrappingTenancy::class => [],
            Events\TenancyBootstrapped::class => [],
            Events\RevertingToCentralContext::class => [],
            Events\RevertedToCentralContext::class => [],

            // Resource syncing
            ResourceSyncing\Events\SyncedResourceSaved::class => [
                ResourceSyncing\Listeners\UpdateOrCreateSyncedResource::class,
            ],
            ResourceSyncing\Events\SyncMasterDeleted::class => [
                ResourceSyncing\Listeners\DeleteResourcesInTenants::class,
            ],
            ResourceSyncing\Events\SyncMasterRestored::class => [
                ResourceSyncing\Listeners\RestoreResourcesInTenants::class,
            ],
            ResourceSyncing\Events\CentralResourceAttachedToTenant::class => [
                ResourceSyncing\Listeners\CreateTenantResource::class,
            ],
            ResourceSyncing\Events\CentralResourceDetachedFromTenant::class => [
                ResourceSyncing\Listeners\DeleteResourceInTenant::class,
            ],
            // Fired only when a synced resource is changed in a different DB than the origin DB (to avoid infinite loops)
            ResourceSyncing\Events\SyncedResourceSavedInForeignDatabase::class => [],

            // Storage symlinks
            Events\CreatingStorageSymlink::class => [],
            Events\StorageSymlinkCreated::class => [],
            Events\RemovingStorageSymlink::class => [],
            Events\StorageSymlinkRemoved::class => [],
        ];
    }

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->bootEvents();
        $this->mapRoutes();

        $this->makeTenancyMiddlewareHighestPriority();
        $this->overrideUrlInTenantContext();

        /**
         * Include soft deleted resources in synced resource queries.
         *
         * ResourceSyncing\Listeners\UpdateOrCreateSyncedResource::$scopeGetModelQuery = function (Builder $query) {
         *     if ($query->hasMacro('withTrashed')) {
         *         $query->withTrashed();
         *     }
         * };
         */

        /**
         * To make Livewire v3 work with Tenancy, make the update route universal.
         *
         * Livewire::setUpdateRoute(function ($handle) {
         *     return RouteFacade::post('/livewire/update', $handle)->middleware(['web', 'universal']);
         * });
         */
        if (InitializeTenancyByRequestData::inGlobalStack()) {
            TenancyUrlGenerator::$prefixRouteNames = false;
        }

        if (tenancy()->globalStackHasMiddleware(config('tenancy.identification.path_identification_middleware'))) {
            TenancyUrlGenerator::$prefixRouteNames = true;
        }
    }

    protected function overrideUrlInTenantContext(): void
    {
        /**
         * Import your tenant model!
         *
         * \Stancl\Tenancy\Bootstrappers\RootUrlBootstrapper::$rootUrlOverride = function (Tenant $tenant, string $originalRootUrl) {
         *     $tenantDomain = $tenant instanceof \Stancl\Tenancy\Contracts\SingleDomainTenant
         *         ? $tenant->domain
         *         : $tenant->domains->first()->domain;
         *
         *     $scheme = str($originalRootUrl)->before('://');
         *
         *     // If you're using subdomain identification:
         *     // $originalDomain = str($originalRootUrl)->after($scheme . '://');
         *     // return $scheme . '://' . $tenantDomain . '.' . $originalDomain . '/';
         *
         *     // If you're using domain identification:
         *     return $scheme . '://' . $tenantDomain . '/';
         * };
         */
    }

    protected function bootEvents()
    {
        foreach ($this->events() as $event => $listeners) {
            foreach ($listeners as $listener) {
                if ($listener instanceof JobPipeline) {
                    $listener = $listener->toListener();
                }

                Event::listen($event, $listener);
            }
        }
    }

    protected function mapRoutes()
    {
        $this->app->booted(function () {
            if (file_exists(base_path('routes/tenant.php'))) {
                RouteFacade::namespace(static::$controllerNamespace)
                    ->middleware('tenant')
                    ->group(base_path('routes/tenant.php'));
            }

            // Delete this condition when using route-level path identification
            if (tenancy()->globalStackHasMiddleware(config('tenancy.identification.path_identification_middleware'))) {
                $this->cloneRoutes();
            }
        });
    }

    /**
     * Clone universal routes as tenant.
     *
     * @see CloneRoutesAsTenant
     */
    protected function cloneRoutes(): void
    {
        /** @var CloneRoutesAsTenant $cloneRoutes */
        $cloneRoutes = $this->app->make(CloneRoutesAsTenant::class);

        /**
         * You can provide a closure for cloning a specific route, e.g.:
         * $cloneRoutes->cloneUsing('welcome', function () {
         *      RouteFacade::get('/tenant-welcome', fn () => 'Current tenant: ' . tenant()->getTenantKey())
         *          ->middleware(['universal', InitializeTenancyByPath::class])
         *          ->name('tenant.welcome');
         * });
         *
         * To see the default behavior of cloning the universal routes, check out the cloneRoute() method in CloneRoutesAsTenant.
         */
        $cloneRoutes->handle();
    }

    protected function makeTenancyMiddlewareHighestPriority()
    {
        // PreventAccessFromUnwantedDomains has even higher priority than the identification middleware
        $tenancyMiddleware = array_merge([Middleware\PreventAccessFromUnwantedDomains::class], config('tenancy.identification.middleware'));

        foreach (array_reverse($tenancyMiddleware) as $middleware) {
            $this->app[\Illuminate\Contracts\Http\Kernel::class]->prependToMiddlewarePriority($middleware);
        }
    }
}
