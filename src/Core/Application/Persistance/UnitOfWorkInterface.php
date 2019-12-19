<?php

namespace App\Core\Application\Persistance;

interface UnitOfWorkInterface
{
    public function commit(): void;

    public function commitTransactional(callable $operation);
}
