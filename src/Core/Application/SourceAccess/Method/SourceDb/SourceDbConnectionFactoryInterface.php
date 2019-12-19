<?php

namespace App\Core\Application\SourceAccess\Method\SourceDb;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;

interface SourceDbConnectionFactoryInterface
{
    public function create(SourceDbDto $sourceDbDto): SourceDbConnectionInterface;
}
