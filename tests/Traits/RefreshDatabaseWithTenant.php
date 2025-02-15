<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\Facades\URL;
use Modules\Tenant\Models\Tenant;

trait RefreshDatabaseWithTenant
{
    use RefreshDatabase {
        beginDatabaseTransaction as parentBeginDatabaseTransaction;
    }

    protected array $connectionsToTransact = [null, 'tenant'];

    public function beginDatabaseTransaction()
    {
        $this->initializeTenant();
        $this->parentBeginDatabaseTransaction();
    }

    public function initializeTenant(): void
    {
        $tenantId = 'foo';

        $tenant = Tenant::firstOr(function () use ($tenantId) {

            config(['tenancy.database.prefix' => config('tenancy.database.prefix') . ParallelTesting::token() . '_']);

            $dbName = config('tenancy.database.prefix') . $tenantId;

            DB::unprepared("DROP DATABASE IF EXISTS {$dbName}");

            $t = Tenant::create([
                'id' => $tenantId,
                'modules' => ['test'],
            ]);
            if (! $t->domains()->count()) {
                $t->domains()->create(['domain' => $tenantId]);
            }

            return $t;
        });

        tenancy()->initialize($tenant);

        URL::forceRootUrl('http://foo.localhost');
    }
}
