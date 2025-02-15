<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Http\Response;
use Modules\Auth\Models\Permission;
use Modules\Auth\Models\Role;
use Tests\Feature\Auth\Helpers\UsersHelper;

abstract class AuthenticatedTestCase extends TestCase
{
    protected function loginAndGetToken(?Role $role = null): string
    {
        $user = UsersHelper::createTestUser($role);
        $params = [
            'login' => $user->login,
            'password' => 'password',
        ];

        $response = $this->postJson(
            'api/v1/auth/login',
            $params,
            [
                'X-Domain' => 'foo',
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['type', 'token']);

        return $response->json('token');
    }

    protected function loginAndGetTokenWithPermissions(array $permissions): string
    {
        $role = new Role([
            'name' => 'test-role',
            'description' => 'Test Role',
        ]);
        $role->save();

        foreach ($permissions as $permission) {
            $role->givePermissionTo(Permission::findByName($permission));
        }

        return $this->loginAndGetToken($role);
    }
}
