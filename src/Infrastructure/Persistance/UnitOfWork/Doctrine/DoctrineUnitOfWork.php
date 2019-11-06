<?php

namespace App\Infrastructure\Persistance\UnitOfWork\Doctrine;

use App\Core\Application\Persistance\UnitOfWorkInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineUnitOfWork implements UnitOfWorkInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function commit(): void
    {
        $this->entityManager->flush();
    }

    public function commitTransactional(callable $operation)
    {
        return $this->entityManager->transactional($operation);
    }
}
