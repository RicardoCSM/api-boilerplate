<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Actions;

use Modules\Questionnaires\DTOs\UpdateQuestionnairesGroupDTO;
use Modules\Questionnaires\Models\QuestionnairesGroup;

final readonly class UpdateQuestionnairesGroup
{
    public function __construct(
        private FetchQuestionnairesGroup $fetchQuestionnairesGroup,
    ) {}

    public function handle(string $uuid, UpdateQuestionnairesGroupDTO $dto): QuestionnairesGroup
    {
        $questionnairesGroup = $this->fetchQuestionnairesGroup->handle($uuid);
        $updateData = $dto->nullableSafeToArray(QuestionnairesGroup::nullable());

        $questionnairesGroup->fill($updateData);
        $questionnairesGroup->save();

        return $questionnairesGroup;
    }
}
