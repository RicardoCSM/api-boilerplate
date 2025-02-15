<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Actions;

use Modules\Questionnaires\DTOs\CreateQuestionnairesGroupDTO;
use Modules\Questionnaires\Models\QuestionnairesGroup;

final readonly class CreateQuestionnairesGroup
{
    public function handle(CreateQuestionnairesGroupDTO $dto): QuestionnairesGroup
    {
        $questionnairesGroup = $dto->toModel(QuestionnairesGroup::class);

        $questionnairesGroup->save();

        return $questionnairesGroup;
    }
}
