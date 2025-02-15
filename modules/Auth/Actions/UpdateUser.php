<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\DTOs\UpdateUserDTO;
use Modules\Auth\Exceptions\AccessDeniedException;
use Modules\Auth\Models\User;

final readonly class UpdateUser
{
    public function __construct(
        private FetchUser $fetchUser,
    ) {}

    public function handle(string $uuid, UpdateUserDTO $dto): User
    {
        $authUser = Auth::user();
        $user = $this->fetchUser->handle($uuid);

        Gate::denyIf($authUser->uuid !== $uuid && ! Gate::allows('ALL-edit-users', $user));

        $updateData = collect($dto->toArray())->filter(fn (string|bool|null|array $item) => ! is_null($item))->toArray();

        Gate::denyIf(! Gate::allows('ALL-edit-users-status', $user) && isset($updateData['active']));
        Gate::denyIf($authUser->uuid !== $uuid && isset($updateData['password']));

        $updateData = $this->buildPasswordData($user, $updateData);

        $user->fill($updateData);
        $user->save();

        return $user;
    }

    private function buildPasswordData(User $user, array $updateData): array
    {
        if (! empty($updateData['password'])) {
            if (! Hash::check($updateData['current_password'], $user->password)) {
                throw new AccessDeniedException('Senha atual inválida.');
            }
            $updateData['password'] = Hash::make($updateData['password']);
        }

        unset($updateData['current_password']);

        return $updateData;
    }
}
