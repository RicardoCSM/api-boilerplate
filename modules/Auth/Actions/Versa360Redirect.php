<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Http;
use Modules\Auth\Models\User;
use Modules\Auth\Models\Versa360ScopePermissionMap;

final readonly class Versa360Redirect
{
    public function __construct(private LoggedUser $loggedUser) {}

    public function handle(): array
    {
        $credentials = tenant()->versa360Credential;
        $scopes = $this->getScopesForUser($this->loggedUser->handle());

        $response = Http::post('https://api.versa360.com.br/v1/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $credentials->client_id,
            'client_secret' => $credentials->client_secret,
            'scope' => implode(' ', $scopes),
        ]);

        return [
            'url' => 'https://versa360.com.br/callback?' . http_build_query([
                'token' => $response->json()['access_token'],
                'workspace_id' => $credentials->workspace_id,
            ]),
        ];
    }

    private function getScopesForUser(User $user): array
    {
        $scopes = [];

        $scopeMappings = Versa360ScopePermissionMap::all();

        foreach ($scopeMappings as $mapping) {
            if ($user->hasAllPermissions($mapping->permissions)) {
                $scopes[] = $mapping->scope_id;
            }
        }

        return $scopes;
    }
}
