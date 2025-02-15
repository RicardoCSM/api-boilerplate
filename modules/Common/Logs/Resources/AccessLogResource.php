<?php

declare(strict_types=1);

namespace Modules\Common\Logs\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'action' => $this->action->description(),
            'module' => $this->module->description(),
            'user_name' => $this->user_name,
            'message' => $this->message,
            'created_at' => $this->created_at,
        ];
    }
}
