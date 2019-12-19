<?php

namespace App\Core\Domain\SourceAccess\Repository;

use App\Core\Domain\Shared\Repository\DomainRepositoryInterface;
use App\Core\Domain\SourceAccess\Model\DataType\DataType;

interface DataTypeRepositoryInterface extends DomainRepositoryInterface
{
    public function findOne(int $id): ?DataType;

    public function findOneByName(string $name): ?DataType;

    public function add(DataType $dataType): void;

    public function remove(DataType $dataType): void;
}
