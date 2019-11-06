<?php

namespace App\Infrastructure\SourceAccess\Method\SourceDb;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\SourceAccess\Method\SourceDbConnectionFactoryInterface;
use App\Core\Application\SourceAccess\Method\SourceDbConnectionInterface;

final class SourceDbConnectionFactory implements SourceDbConnectionFactoryInterface
{
    public function create(SourceDbDto $sourceDbDto): SourceDbConnectionInterface
    {
        return new SafeMySQLSourceDbConnection($sourceDbDto);
    }
}
