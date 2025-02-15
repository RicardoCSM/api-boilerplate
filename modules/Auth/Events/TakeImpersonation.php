<?php

declare(strict_types=1);

namespace Modules\Auth\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Auth\Models\User;

class TakeImpersonation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $impersonator, public User $impersonated) {}
}
