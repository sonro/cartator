<?php

namespace App\Infrastructure\Persistance\Repository\Doctrine;

use App\Core\Domain\Resource\Model\SourceApp\SourceApp;
use App\Core\Domain\Resource\Repository\SourceAppRepositoryInterface;

final class DoctrineSourceAppRepository implements SourceAppRepositoryInterface
{
    use DoctrineEntityManagerTrait;

    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(SourceApp::class)
            ->findAll();
    }

    public function findOne(int $id): ?SourceApp
    {
        return $this->entityManager
            ->getRepository(SourceApp::class)
            ->find($id);
    }

    public function findOneByName(string $name): ?SourceApp
    {
        return $this->entityManager
            ->getRepository(SourceApp::class)
            ->findOneByName($name);
    }

    public function add(SourceApp $sourceApp): void
    {
        $this->entityManager->persist($sourceApp);
    }

    public function remove(SourceApp $sourceApp): void
    {
        $this->entityManager->remove($sourceApp);
    }

    public function size(): int
    {
        return $this->entityManager->createQueryBuilder()
            ->select('count(sa.id)')
            ->from(SourceApp::class, 'sa')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
