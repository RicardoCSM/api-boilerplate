<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Actions;

use Modules\DocumentAI\DTOs\DocumentAIDTO;
use Modules\DocumentAI\Exceptions\InvalidDocumentException;
use Modules\DocumentAI\Support\DocumentAI;

final readonly class GetCpf
{
    public function handle(DocumentAIDTO $dto): array
    {
        $processorId = env('DOCUMENT_AI_CPF_PROCESSOR_ID');
        $document = DocumentAI::processDocument($dto->file, $processorId);
        $entities = DocumentAI::repeatedFieldToArray($document->getEntities());

        $cpf = $this->buildCpf($entities);

        if ($cpf === null) {
            throw new InvalidDocumentException();
        }

        return [
            'cpf' => $cpf,
        ];
    }

    public function buildCpf(array $entities): ?string
    {
        $cpf = DocumentAI::getValueByType($entities, 'cpf');
        $cpf = preg_replace('/\D/', '', $cpf);

        if ($cpf === null || strlen($cpf) !== 11) {
            return null;
        }

        $cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);

        return $cpf;
    }
}
