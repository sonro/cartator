<?php

namespace App\Infrastructure\Persistance\Repository\Doctrine;

use App\Core\Domain\SourceAccess\Model\SourceQuerier\SourceQuerier;
use App\Core\Domain\SourceAccess\Repository\SourceQuerierRepositoryInterface;

final class DoctrineSourceQuerierRepository implements SourceQuerierRepositoryInterface
{
    use DoctrineEntityManagerTrait;

    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(SourceQuerier::class)
            ->findAll();
    }

    public function findOne(int $id): ?SourceQuerier
    {
        return $this->entityManager
            ->getRepository(SourceQuerier::class)
            ->find($id);
    }

    public function findOneByClassName(string $className): ?SourceQuerier
    {
        return $this->entityManager
            ->getRepository(SourceQuerier::class)
            ->findOneByClassName($className);
    }

    public function add(SourceQuerier $sourceQuerier): void
    {
        $this->entityManager->persist($sourceQuerier);
    }

    public function remove(SourceQuerier $sourceQuerier): void
    {
        $this->entityManager->remove($sourceQuerier);
    }

    public function size(): int
    {
        return $this->entityManager->createQueryBuilder()
            ->select('count(sq.id)')
            ->from(SourceQuerier::class, 'sq')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
