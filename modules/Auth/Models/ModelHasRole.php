<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class ModelHasRole extends Model
{
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id',
    ];

    protected static function members(Builder $query, string $role): Builder
    {
        return $query
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->leftJoin('users', 'users.id', '=', 'model_has_roles.model_id')
            ->where('roles.name', $role);
    }
}
