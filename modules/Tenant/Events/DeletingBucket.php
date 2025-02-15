<?php

declare(strict_types=1);

namespace Modules\Tenant\Events;

use Stancl\Tenancy\Events\Contracts\TenantEvent;

class DeletingBucket extends TenantEvent {}
