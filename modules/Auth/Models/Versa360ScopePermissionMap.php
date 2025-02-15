<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Common\Core\Models\Concerns\HasUuids;

final class Versa360ScopePermissionMap extends Model
{
    use HasUuids;

    protected $table = 'versa360_scopes_permissions_map';

    protected $fillable = [
        'uuid',
        'scope_id',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];
}
