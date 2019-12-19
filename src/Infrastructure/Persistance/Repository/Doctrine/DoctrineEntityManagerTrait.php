<?php

namespace App\Infrastructure\Persistance\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

trait DoctrineEntityManagerTrait
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
