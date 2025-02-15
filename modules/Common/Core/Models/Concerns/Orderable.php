<?php

declare(strict_types=1);

namespace Modules\Common\Core\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

trait Orderable
{
    private static string $defaultOrderField = 'order';

    private static string $defaultOrderDirection = 'asc';

    public static function bootOrderable(): void
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy(static::getOrderField(), static::getOrderDirection());
        });
    }

    public static function fetchNewOrder(?string $parentId = null): int
    {
        $table = (new static())->getTable();

        if (in_array('parent_id', (new static())->getFillable())) {
            return $parentId
                ? self::join($table . ' as parent', 'parent.id', '=', $table . '.parent_id')
                    ->where('parent.uuid', $parentId)
                    ->max($table . '.order') + 1
                : self::whereNull('parent_id')->max('order') + 1;
        }

        return self::max('order') + 1;
    }

    public static function fetchNewOrderWhere(string $column, mixed $value): int
    {
        return self::where($column, $value)->max('order') + 1;
    }

    public static function nextOrder(): int
    {
        return static::max(static::getOrderField()) + 1;
    }

    public function setOrder(int $order): void
    {
        $this->{static::getOrderField()} = $order;
    }

    private static function getOrderField(): string
    {
        return static::$orderField ?? static::$defaultOrderField;
    }

    private static function getOrderDirection(): string
    {
        $orderDirection = static::$orderDirection ?? static::$defaultOrderDirection;

        if (! in_array($orderDirection, ['asc', 'desc'])) {
            throw new InvalidArgumentException("Direção de ordem inválida: {$orderDirection}. Esperado 'asc' ou 'desc'.");
        }

        return $orderDirection;
    }
}
