<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Facades\Tenancy;

class Versa360Credential extends Model
{
    protected $fillable = [
        'client_id',
        'client_secret',
        'workspace_id',
        'tenant_id',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenancy::getTenantModel(), 'id', 'tenant_id');
    }
}
