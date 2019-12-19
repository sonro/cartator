<?php

namespace App\Core\Application\Service;

use App\Core\Application\Persistance\UnitOfWorkInterface;
use App\Core\Domain\SourceAccess\Repository\SourceQuerierRepositoryInterface;
use App\Core\Domain\SourceAccess\Model\SourceQuerier\SourceQuerier;
use App\Core\Application\DataTransfer\Dto\SourceQuerierDto;
use App\Core\Domain\Resource\Model\SourceApp\SourceApp;
use App\Core\Domain\Resource\Repository\SourceAppRepositoryInterface;
use App\Core\Domain\SourceAccess\Model\DataType\DataType;
use App\Core\Domain\SourceAccess\Model\Shared\AccessorMethod;
use App\Core\Domain\SourceAccess\Repository\DataTypeRepositoryInterface;
use Exception;

final class SourceQuerierService
{
    /**
     * @var UnitOfWorkInterface
     */
    private $unitOfWork;

    /**
     * @var SourceQuerierRepositoryInterface
     */
    private $repository;

    /**
     * @var DataTpyeRepositoryInterface
     */
    private $dataTypeRepository;

    /**
     * @var SourceAppRepositoryInterface
     */
    private $sourceAppRepository;

    public function __construct(
        UnitOfWorkInterface $unitOfWork,
        SourceQuerierRepositoryInterface $repository,
        DataTypeRepositoryInterface $dataTypeRepository,
        SourceAppRepositoryInterface $sourceAppRepository
    ) {
        $this->unitOfWork = $unitOfWork;
        $this->repository = $repository;
        $this->dataTypeRepository = $dataTypeRepository;
        $this->sourceAppRepository = $sourceAppRepository;
    }

    /**
     * Persist multiple SourceQuerierDtos.
     *
     * Check if the indicated SourceQuerier is already stored in
     * repository, make sure it has all the same properties. Persist
     * new SourceQueriers and update any changes.
     *
     * @param SourceQuerierDto[] $sourceQuerierDtos
     * @param bool               $commit            Commit the repository state.
     *                                              Default = true
     *
     * @return SourceQuerier[]
     */
    public function persistMultipleDtos(array $sourceQuerierDtos, bool $commit = true): array
    {
        $sourceQueriers = [];

        foreach ($sourceQuerierDtos as $dto) {
            $sourceQueriers[] = $this->persistFromDto($dto, false);
        }

        if ($commit) {
            $this->unitOfWork->commit();
        }

        return $sourceQueriers;
    }

    public function persistFromDto(SourceQuerierDto $dto, bool $commit = true): SourceQuerier
    {
        $querier = $this->repository->findOneByClassName($dto->getClassName());
        if ($querier !== null) {
            $sameInterface =
                $querier->getInterfaceName() === $dto->getInterfaceName();
            $sameDataType =
                $querier->getDataType()->getName() === $dto->getDataTypeName();
            $sameSourceApp =
                $querier->getSourceApp()->getName() === $dto->getSourceAppName();

            if ($sameInterface && $sameDataType && $sameSourceApp) {
                return $querier;
            }

            if (!$sameInterface) {
                $querier->setInterfaceName($dto->getInterfaceName());
            }
            if (!$sameDataType) {
                $querier->setDataType($this->fetchDataType($dto->getDataTypeName()));
            }
            if (!$sameSourceApp) {
                $querier->setSourceApp($this->fetchSourceApp($dto->getSourceAppName()));
            }
        } else {
            $querier = new SourceQuerier();
            $querier->setClassName($dto->getClassName());
            $querier->setInterfaceName($dto->getInterfaceName());
            $querier->setMethod(new AccessorMethod($dto->getMethodName()));
            $querier->setDataType($this->fetchDataType($dto->getDataTypeName()));
            $querier->setSourceApp($this->fetchSourceApp($dto->getSourceAppName()));
            $this->repository->add($querier);
        }

        if ($commit) {
            $this->unitOfWork->commit();
        }

        return $querier;
    }

    private function fetchDataType(string $dataTypeName): DataType
    {
        $dataType = $this->dataTypeRepository
            ->findOneByName($dataTypeName);
        if ($dataType === null) {
            $this->throwFetchException($dataTypeName, 'DataType');
        }

        return $dataType;
    }

    private function fetchSourceApp(string $sourceAppName): SourceApp
    {
        $sourceApp = $this->sourceAppRepository
            ->findOneByName($sourceAppName);
        if ($sourceApp === null) {
            $this->throwFetchException($sourceAppName, 'SourceApp');
        }

        return $sourceApp;
    }

    private function throwFetchException(string $attemptedName, string $attemptedType)
    {
        throw new Exception(
            "No known $attemptedType found while trying "
            ."to persist SourceQuerier: $attemptedName"
        );
    }
}
