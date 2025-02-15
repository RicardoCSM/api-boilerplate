<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Tenant\DTOs\CreateTenantDTO;
use Modules\Tenant\Models\Tenant;
use Stancl\Tenancy\Jobs\SeedDatabase;
use Throwable;

final readonly class CreateTenant
{
    public function handle(CreateTenantDTO $dto): Tenant
    {
        try {
            DB::beginTransaction();

            $tenant = $this->createTenant($dto);

            $this->setupTenantDomain($tenant, $dto);

            $this->seedDatabaseIfRequired($tenant, $dto);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $tenant;
    }

    private function createTenant(CreateTenantDTO $dto): Tenant
    {
        $keycloak_clients = [];
        if (isset($dto->keycloak_client)) {
            foreach ($dto->keycloak_client as $client) {
                $keycloak_clients[$client['keycloak_client_id']]['keycloak_client_secret'] = $client['keycloak_client_secret'];
            }
        }

        return Tenant::create([
            'name' => $dto->name,
            'keycloak_realm_id' => $dto->keycloak_realm_id,
            'keycloak_realm_public_key' => $dto->keycloak_realm_public_key,
            'keycloak_clients' => $keycloak_clients,
        ]);
    }

    private function setupTenantDomain(Tenant $tenant, CreateTenantDTO $dto): void
    {
        $tenant->domains()->create(['domain' => $dto->domain]);
    }

    private function seedDatabaseIfRequired(Tenant $tenant, CreateTenantDTO $dto): void
    {
        if ($dto->should_seed_database) {
            (new SeedDatabase($tenant))->handle();
        }
    }
}
