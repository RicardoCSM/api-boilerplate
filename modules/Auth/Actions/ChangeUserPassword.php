<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Auth\DTOs\ChangeUserPasswordDTO;

final readonly class ChangeUserPassword
{
    public function __construct(
        private FetchUser $fetchUser,
    ) {}

    public function handle(string $uuid, ChangeUserPasswordDTO $dto): void
    {
        $user = $this->fetchUser->handle($uuid);

        $user->forceFill([
            'password' => Hash::make($dto->password),
            'remember_token' => Str::random(60),
        ])->save();
    }
}
