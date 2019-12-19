<?php

namespace App\Infrastructure\Persistance\Repository\Doctrine;

use App\Core\Domain\SourceAccess\Model\DataType\DataType;
use App\Core\Domain\SourceAccess\Repository\DataTypeRepositoryInterface;

final class DoctrineDataTypeRepository implements DataTypeRepositoryInterface
{
    use DoctrineEntityManagerTrait;

    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(DataType::class)
            ->findAll();
    }

    public function findOne(int $id): ?DataType
    {
        return $this->entityManager
            ->getRepository(DataType::class)
            ->find($id);
    }

    public function findOneByName(string $name): ?DataType
    {
        return $this->entityManager
            ->getRepository(DataType::class)
            ->findOneByName($name);
    }

    public function add(DataType $dataType): void
    {
        $this->entityManager->persist($dataType);
    }

    public function remove(DataType $dataType): void
    {
        $this->entityManager->remove($dataType);
    }

    public function size(): int
    {
        return $this->entityManager->createQueryBuilder()
            ->select('count(sq.id)')
            ->from(DataType::class, 'sq')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
