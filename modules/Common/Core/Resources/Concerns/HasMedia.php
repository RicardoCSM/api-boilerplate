<?php

declare(strict_types=1);

namespace Modules\Common\Core\Resources\Concerns;

trait HasMedia
{
    private function shouldIncludeMedia(): bool
    {
        return request()->has('include') && in_array('media', explode(',', request()->input('include')));
    }

    private function resolveMediaSize(string $attribute): string
    {
        $key = $attribute . '_size';

        return request()->has($key) ? request()->input($key) : 'original';
    }
}
