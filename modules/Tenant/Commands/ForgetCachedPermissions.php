<?php

declare(strict_types=1);

namespace Modules\Tenant\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\PermissionRegistrar;
use Stancl\Tenancy\Concerns\HasTenantOptions;

class ForgetCachedPermissions extends Command
{
    use HasTenantOptions;

    protected $signature = 'tenants:forget-cached-permissions';

    protected $description = 'Forget cached permissions for tenant(s).';

    public function handle(): int
    {
        tenancy()->runForMultiple($this->getTenants(), function ($tenant) {
            $this->components->info("Tenant: {$tenant->getTenantKey()}");

            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            $this->components->info('Cached permissions forgotten.');
        });

        return 0;
    }
}
