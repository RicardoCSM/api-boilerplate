<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Common\Core\DTOs\DatatableDTO;
use Modules\Common\Core\Support\Datatable;
use Modules\Tenant\Filters\AdsFilters;
use Modules\Tenant\Models\Ads;

final readonly class FetchAdsList
{
    public function __construct(private AdsFilters $filters) {}

    public function handle(DatatableDTO $dto): LengthAwarePaginator|Collection
    {
        $query = Ads::filtered($this->filters)->ordered();

        $query = Datatable::applyFilter($query, $dto, ['title']);
        $query = Datatable::applySort($query, $dto);

        return Datatable::applyPagination($query, $dto);
    }
}
