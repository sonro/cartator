<?php

namespace App\Unit\Core\Application\DataTransfer\Hydrator;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\DataTransfer\Hydrator\SourceDbDtoHydrator;
use App\Core\Application\Service\DbUserService;
use App\Core\Application\Util\Encoder\SensitiveStringEncoder;
use App\Core\Domain\Resource\Model\SourceDb\DbHost;
use App\Core\Domain\Resource\Model\SourceDb\DbUser;
use App\Core\Domain\Resource\Model\SourceDb\SourceDb;
use PHPUnit\Framework\TestCase;

final class SourceDbDtoHydratorTest extends TestCase
{
    /**
     * @var SourceDbDtoHydrator
     */
    private $hydrator;

    /**
     * @var DbUserService
     */
    private $dbUserService;

    protected function setUp()
    {
        $key = 'test-key';
        $encoder = new SensitiveStringEncoder($key);
        $dbUserService = new DbUserService($encoder);
        $this->dbUserService = $dbUserService;
        $this->hydrator = new SourceDbDtoHydrator($dbUserService);
    }

    public function testCreateSourceDbDto()
    {
        $testDb = 'testName';
        $testCharset = 'utf16';
        $testHost = '127.0.0.1';
        $testPort = 3301;
        $testUser = 'testUser';
        $testPass = 'testPass';

        $pureDto = new SourceDbDto(
            $testHost,
            $testPort,
            $testUser,
            $testPass,
            $testDb,
            $testCharset
        );

        $dbHost = new DbHost();
        $dbHost->setAddress($testHost);
        $dbHost->setPort($testPort);

        $dbUser = new DbUser();
        $dbUser->setDbHost($dbHost);
        $this->dbUserService->encodePassword($dbUser, $testPass);
        $this->dbUserService->encodeUsername($dbUser, $testUser);

        $sourceDb = new SourceDb();
        $sourceDb->setDbHost($dbHost);
        $sourceDb->setDbName($testDb);
        $sourceDb->setDbCharset($testCharset);
        $sourceDb->setDbUser($dbUser);

        $hydratedDto = $this->hydrator->createSourceDbDto($sourceDb);

        $this->assertEquals($pureDto, $hydratedDto);
    }

    public function testCreateModel()
    {
        $testDb = 'testName';
        $testCharset = 'utf16';
        $testHost = '127.0.0.1';
        $testPort = 3301;
        $testUser = 'testUser';
        $testPass = 'testPass';

        $dbHost = new DbHost();
        $dbHost->setAddress($testHost);
        $dbHost->setPort($testPort);

        $dbUser = new DbUser();
        $dbUser->setDbHost($dbHost);
        $this->dbUserService->encodePassword($dbUser, $testPass);
        $this->dbUserService->encodeUsername($dbUser, $testUser);

        $expectedDb = new SourceDb();
        $expectedDb->setDbHost($dbHost);
        $expectedDb->setDbName($testDb);
        $expectedDb->setDbCharset($testCharset);
        $expectedDb->setDbUser($dbUser);

        $dto = new SourceDbDto(
            $testHost,
            $testPort,
            $testUser,
            $testPass,
            $testDb,
            $testCharset
        );

        $hydratedDb = $this->hydrator->createModel($dto);

        $this->assertInstanceOf(SourceDb::class, $hydratedDb);
        $this->assertEquals(
            $expectedDb->getDbHost(),
            $hydratedDb->getDbHost()
        );
        $this->assertEquals(
            $expectedDb->getDbName(),
            $hydratedDb->getDbName()
        );
        $this->assertEquals(
            $this->dbUserService->getPlainUsername($expectedDb->getDbUser()),
            $this->dbUserService->getPlainUsername($hydratedDb->getDbUser())
        );
        $this->assertEquals(
            $this->dbUserService->getPlainPassword($expectedDb->getDbUser()),
            $this->dbUserService->getPlainPassword($hydratedDb->getDbUser())
        );
    }
}
