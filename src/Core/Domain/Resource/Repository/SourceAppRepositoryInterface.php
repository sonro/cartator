<?php

namespace App\Core\Domain\Resource\Repository;

use App\Core\Domain\Resource\Model\SourceApp\SourceApp;
use App\Core\Domain\Shared\Repository\DomainRepositoryInterface;

interface SourceAppRepositoryInterface extends DomainRepositoryInterface
{
    public function findOne(int $id): ?SourceApp;

    public function findOneByName(string $name): ?SourceApp;

    public function add(SourceApp $sourceApp): void;

    public function remove(SourceApp $sourceApp): void;
}
