<?php

declare(strict_types=1);

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Modules\Common\Core\Resources\Concerns\HasMedia;
use Modules\Common\Core\Resources\MediaResource;

final class UserResource extends JsonResource
{
    use HasMedia;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'login' => $this->login,
            'email' => $this->email,
            'roles' => $this->whenLoaded('roles', $this->roles->pluck('name')),
            'permissions' => $this->whenLoaded('roles', fn () => $this->getAllPermissions()->pluck('name')),
            'active' => $this->active,
            'avatar' => $this->getFirstTemporaryUrl(Carbon::now()->addHours(2), 'avatars', 'large') ?: null,
            $this->mergeWhen($this->shouldIncludeMedia(), [
                'media' => MediaResource::collection($this->getMedia('*')),
            ]),
            'last_login_at' => $this->whenLoaded('latestLogin', fn () => $this->latestLogin->created_at),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
