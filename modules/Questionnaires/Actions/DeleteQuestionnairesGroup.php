<?php

declare(strict_types=1);

namespace Modules\Questionnaires\Actions;

use Exception;

final readonly class DeleteQuestionnairesGroup
{
    public function __construct(private FetchQuestionnairesGroup $fetchQuestionnairesGroup) {}

    public function handle(string $uuid): void
    {
        $questionnairesGroup = $this->fetchQuestionnairesGroup->handle($uuid);

        if ($questionnairesGroup->active) {
            throw new Exception('Não é possível deletar um questionário ativo.', 400);
        }

        foreach ($questionnairesGroup->questionnaires as $questionnaire) {
            if ($questionnaire->active) {
                throw new Exception('Não é possível deletar um grupo de questionários com questionários ativos.', 400);
            }
        }

        $questionnairesGroup->delete();
    }
}
