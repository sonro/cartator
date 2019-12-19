<?php

namespace App\Core\Domain\SourceAccess\Repository;

use App\Core\Domain\Shared\Repository\DomainRepositoryInterface;
use App\Core\Domain\SourceAccess\Model\SourceQuerier\SourceQuerier;

interface SourceQuerierRepositoryInterface extends DomainRepositoryInterface
{
    public function findOne(int $id): ?SourceQuerier;

    public function findOneByClassName(string $className): ?SourceQuerier;

    public function add(SourceQuerier $sourceQuerier): void;

    public function remove(SourceQuerier $sourceQuerier): void;
}
