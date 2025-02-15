<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Common\Core\DTOs\DatatableDTO;
use Modules\Common\Core\Support\Datatable;
use Modules\Tenant\Filters\ThemeFilters;
use Modules\Tenant\Models\Theme;

final readonly class FetchThemeList
{
    public function __construct(private ThemeFilters $filters) {}

    public function handle(DatatableDTO $dto): LengthAwarePaginator|Collection
    {
        $query = Theme::filtered($this->filters)->orderBy('created_at', 'desc');

        $query = Datatable::applyFilter($query, $dto, ['title']);
        $query = Datatable::applySort($query, $dto);

        return Datatable::applyPagination($query, $dto);
    }
}
