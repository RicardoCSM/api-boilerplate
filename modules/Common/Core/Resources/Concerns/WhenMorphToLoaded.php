<?php

declare(strict_types=1);

namespace Modules\Common\Core\Resources\Concerns;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

trait WhenMorphToLoaded
{
    public function whenMorphToLoaded(string $name, array $map): JsonResource|MissingValue
    {
        return $this->whenLoaded($name, function () use ($name, $map) {
            $morphType = $name . '_type';
            $morphClass = $this->resource->{$morphType};
            $morphResourceClass = $map[$morphClass];

            return new $morphResourceClass($this->resource->{$name});
        });
    }
}
