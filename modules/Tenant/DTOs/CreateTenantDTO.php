<?php

declare(strict_types=1);

namespace Modules\Tenant\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class CreateTenantDTO extends ValidatedDTO
{
    public string $name;

    public string $domain;

    public ?string $keycloak_realm_id;

    public ?string $keycloak_realm_public_key;

    public ?array $keycloak_client;

    public bool $should_seed_database;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'domain' => ['required', 'string', 'max:255', 'unique:domains,domain'],
            'keycloak_realm_id' => ['nullable', 'string'],
            'keycloak_realm_public_key' => ['nullable', 'string'],
            'keycloak_client' => ['nullable', 'array'],
            'should_seed_database' => ['sometimes', 'boolean'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'should_seed_database' => true,
        ];
    }

    protected function casts(): array
    {
        return [];
    }
}
