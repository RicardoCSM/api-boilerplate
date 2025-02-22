<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Actions;

use Modules\Common\Core\DTOs\Concerns\Rules\Cpf;
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

        $cpfValidator = new Cpf();
        if (! $cpfValidator->validate('cpf', $cpf, function () {})) {
            return null;
        }

        return $cpf;
    }
}
