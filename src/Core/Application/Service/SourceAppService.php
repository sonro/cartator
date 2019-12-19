<?php

namespace App\Core\Application\Service;

use App\Core\Application\DataTransfer\Dto\SourceAppDto;
use App\Core\Application\Persistance\UnitOfWorkInterface;
use App\Core\Domain\Resource\Model\SourceApp\SourceApp;
use App\Core\Domain\Resource\Repository\SourceAppRepositoryInterface;
use App\Core\Domain\SourceAccess\Model\SourceQuerier\SourceQuerier;

final class SourceAppService
{
    /**
     * @var UnitOfWorkInterface
     */
    private $unitOfWork;

    /**
     * @var SourceAppRepositoryInterface
     */
    private $repository;

    public function __construct(
        UnitOfWorkInterface $unitOfWork,
        SourceAppRepositoryInterface $repository
    ) {
        $this->unitOfWork = $unitOfWork;
        $this->repository = $repository;
    }

    /**
     * Persist multiple SourceQuerierDtos.
     *
     * Check if the indicated SourceQuerier is already stored in
     * repository, make sure it has all the same properties. Persist
     * new SourceQueriers and update any changes.
     *
     * @param SourceAppDto[] $sourceQuerierDtos
     * @param bool           $commit            Commit the repository state.
     *                                          Default = true
     *
     * @return SourceApp[]
     */
    public function persistMultipleDtos(
        array $sourceAppDtos,
        bool $commit = true
    ): array {
        $sourceApps = [];

        foreach ($sourceAppDtos as $dto) {
            $sourceApps[] = $this->persistFromDto($dto, false);
        }

        if ($commit) {
            $this->unitOfWork->commit();
        }

        return $sourceApps;
    }

    public function persistFromDto(
        SourceAppDto $dto,
        bool $commit = true
    ): SourceApp {
        $sourceApp = $this->repository->findOneByName($dto->getName());

        if ($sourceApp === null) {
            $sourceApp = new SourceApp();
        }

        $sourceApp->setName($dto->getName());
        $sourceApp->setWebsite($dto->getWebsite());
        $sourceApp->setDownloadsUrl($dto->getDownloadsUrl());
        $sourceApp->setAutoDownload($dto->getDownloadsUrl());
        $this->repository->add($sourceApp);

        if ($commit) {
            $this->unitOfWork->commit();
        }

        return $sourceApp;
    }
}
