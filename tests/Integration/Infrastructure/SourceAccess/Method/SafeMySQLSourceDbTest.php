<?php

namespace App\Integration\Infrastructure\SourceAccess\Method;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\SourceAccess\Method\SourceDbException;
use App\Infrastructure\SourceAccess\Method\SourceDb\SafeMySQLSourceDb;
use PHPUnit\Framework\TestCase;

final class SafeMySQLSourceDbTest extends TestCase
{
    public function testCreateBadConnection()
    {
        $this->expectException(SourceDbException::class);
        $badSourceDbDto = new SourceDbDto(
            '127.0.0.1',
            3306,
            'unkown_user',
            'wrong_password',
            'not-a-database',
            'utf8'
        );

        new SafeMySQLSourceDb($badSourceDbDto);
    }
}
