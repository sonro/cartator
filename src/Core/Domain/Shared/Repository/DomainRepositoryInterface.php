<?php

namespace App\Core\Domain\Shared\Repository;

interface DomainRepositoryInterface
{
    public function findAll(): array;

    public function size(): int;
}
