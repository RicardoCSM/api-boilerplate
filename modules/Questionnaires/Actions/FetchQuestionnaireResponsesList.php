<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Common\Core\DTOs\DatatableDTO;
use Modules\Common\Core\Support\Datatable;
use Modules\Questionnaires\Filters\QuestionnaireResponsesFilters;
use Modules\Questionnaires\Models\QuestionnaireResponse;

final readonly class FetchQuestionnaireResponsesList
{
    public function __construct(
        private QuestionnaireResponsesFilters $filters,
    ) {}

    public function handle(DatatableDTO $dto): LengthAwarePaginator|Collection
    {
        $query = QuestionnaireResponse::query()->filtered($this->filters)->all();
        $query = Datatable::applySort($query, $dto);

        return Datatable::applyPagination($query, $dto);
    }
}
