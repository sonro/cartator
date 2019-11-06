<?php

namespace App\Unit\Infrastructure\SourceAccess\Method\SourceDb;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\SourceAccess\Method\SourceDbConnectionInterface;
use App\Core\Application\SourceAccess\Method\SourceDbException;
use App\Infrastructure\SourceAccess\Method\SourceDb\SourceDbConnectionFactory;
use App\Tests\Integration\SourceDbTestCase;

final class SourceDbConnectionFactoryTest extends SourceDbTestCase
{
    public function testCreate()
    {
        $factory = new SourceDbConnectionFactory();
        $dbConn = $factory->create(self::$sourceDbDto);
        $this->assertInstanceOf(SourceDbConnectionInterface::class, $dbConn);
    }

    public function testBadCreate()
    {
        $badDto = new SourceDbDto(
            'bad-host',
            3300,
            'bad-user',
            'bad-pass',
            'bad-name',
            'utf8'
        );
        $factory = new SourceDbConnectionFactory();
        $this->expectException(SourceDbException::class);
        $factory->create($badDto);
    }
}
