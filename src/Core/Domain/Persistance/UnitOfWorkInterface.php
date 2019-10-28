<?php

namespace App\Core\Domain\Persistance;

interface UnitOfWorkInterface
{
    public function commit(): void;

    public function commitTransactional(callable $operation);
}
