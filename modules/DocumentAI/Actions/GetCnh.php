<?php

declare(strict_types=1);

namespace Modules\DocumentAI\Actions;

use Modules\DocumentAI\DTOs\DocumentAIDTO;
use Modules\DocumentAI\Exceptions\InvalidDocumentException;
use Modules\DocumentAI\Support\DocumentAI;
use Modules\DocumentAI\Support\TreatData;

final readonly class GetCnh
{
    public function __construct(
        private GetCpf $getCpf
    ) {}

    public function handle(DocumentAIDTO $dto): ?array
    {
        $processorId = env('DOCUMENT_AI_CNH_PROCESSOR_ID');
        $document = DocumentAI::processDocument($dto->file, $processorId);
        $entities = DocumentAI::repeatedFieldToArray($document->getEntities());

        $cnhData = $this->buildCnh($entities);

        if ($cnhData === null) {
            throw new InvalidDocumentException();
        }

        return $cnhData;
    }

    public function buildCnh(array $entities): ?array
    {
        $cpf = $this->getCpf->buildCpf($entities);
        $drivingLicenseCategory = DocumentAI::getValueByType($entities, 'categoria-habilitacao');

        if (! $cpf || ! $drivingLicenseCategory) {
            return null;
        }

        $issueDate = TreatData::formatDate(DocumentAI::getValueByType($entities, 'data-emissao'));
        $birthDate = TreatData::formatDate(DocumentAI::getValueByType($entities, 'data-nascimento'));
        $placeOfRegister = TreatData::formatLocal(DocumentAI::getValueByType($entities, 'local'));

        return [
            'nome' => DocumentAI::getValueByType($entities, 'nome'),
            'doc_identidade' => DocumentAI::getValueByType($entities, 'doc-identidade'),
            'org-emissor' => DocumentAI::getValueByType($entities, 'org-emissor'),
            'uf' => DocumentAI::getValueByType($entities, 'uf'),
            'validade' => DocumentAI::getValueByType($entities, 'validade'),
            'cpf' => $cpf,
            'categoria_habilitacao' => $drivingLicenseCategory,
            'data_emissao' => $issueDate,
            'nome_mae' => DocumentAI::getValueByType($entities, 'nome-mae'),
            'nome_pai' => DocumentAI::getValueByType($entities, 'nome-pai'),
            'data_nascimento' => $birthDate,
            'observacoes' => DocumentAI::getValueByType($entities, 'observacoes'),
            'local' => $placeOfRegister,
            'num_registro' => DocumentAI::getValueByType($entities, 'num-registro'),
        ];
    }
}
