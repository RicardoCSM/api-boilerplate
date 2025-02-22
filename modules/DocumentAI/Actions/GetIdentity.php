<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Actions;

use Modules\DocumentAI\DTOs\DocumentAIDTO;
use Modules\DocumentAI\Exceptions\InvalidDocumentException;
use Modules\DocumentAI\Support\DocumentAI;
use Modules\DocumentAI\Support\TreatData;

final readonly class GetIdentity
{
    public function __construct(
        private GetCpf $getCpf
    ) {}

    public function handle(DocumentAIDTO $dto): ?array
    {
        $processorId = env('DOCUMENT_AI_IDENTITY_PROCESSOR_ID');
        $document = DocumentAI::processDocument($dto->file, $processorId);
        $entities = DocumentAI::repeatedFieldToArray($document->getEntities());

        $identityData = $this->buildIdentity($entities);

        if ($identityData === null) {
            throw new InvalidDocumentException();
        }

        return $identityData;
    }

    public function buildIdentity(array $entities): ?array
    {
        $cpf = $this->getCpf->buildCpf($entities);
        $rg = DocumentAI::getValueByType($entities, 'rg');
        if (! $cpf || ! $rg) {
            return null;
        }

        $expeditionDate = TreatData::formatDate(DocumentAI::getValueByType($entities, 'data-expedicao'));
        $birthDate = TreatData::formatDate(DocumentAI::getValueByType($entities, 'data-nascimento'));
        $placeOfBirth = TreatData::formatLocal(DocumentAI::getValueByType($entities, 'naturalidade'));

        return [
            'nome' => DocumentAI::getValueByType($entities, 'nome'),
            'nome_mae' => DocumentAI::getValueByType($entities, 'nome-mae'),
            'nome_pai' => DocumentAI::getValueByType($entities, 'nome-pai'),
            'cpf' => $cpf,
            'rg' => $rg,
            'data_expedicao' => $expeditionDate,
            'data_nascimento' => $birthDate,
            'naturalidade' => $placeOfBirth,
        ];
    }
}
