<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\DTOs\CreateUserDTO;
use Modules\Auth\Models\User;

final readonly class CreateUser
{
    public function handle(CreateUserDTO $dto): User
    {
        $user = $dto->toModel(User::class);
        $user->password = Hash::make($dto->password);
        $user->save();

        $user->assignRole($dto->role);

        if ($dto->extra_permissions) {
            $user->givePermissionTo($dto->extra_permissions);
        }

        return $user;
    }
}
