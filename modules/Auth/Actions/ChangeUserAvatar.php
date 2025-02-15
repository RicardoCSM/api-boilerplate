<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\DTOs\ChangeUserAvatarDTO;
use Modules\Auth\Models\User;

final readonly class ChangeUserAvatar
{
    public function __construct(private FetchUser $fetchUser) {}

    public function handle(string $uuid, ChangeUserAvatarDTO $dto): User
    {
        $user = $this->fetchUser->handle($uuid);

        $user->addMediaFromDisk($dto->file->key, 'central')
            ->usingFileName($dto->file->uuid . '.' . $dto->file->extension)
            ->toMediaCollection('avatars');

        return $user;
    }
}
