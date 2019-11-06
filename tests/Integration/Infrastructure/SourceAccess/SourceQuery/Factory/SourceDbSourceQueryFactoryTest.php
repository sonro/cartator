<?php

namespace App\Integration\Infrastructure\SourceAccess\SourceQuery\Factory;

use App\Core\Application\DataTransfer\Hydrator\SourceDbDtoHydrator;
use App\Core\Application\SourceAccess\SourceQuery\Factory\SourceDbSourceQueryFactory;
use App\Core\Application\SourceAccess\SourceQuery\SourceQueryInterface;
use App\Core\Domain\SourceAccess\Model\SourceQuerier\SourceQuerier;
use App\Tests\DummySourceQuery\FindAllDummySourceQueryInterface;
use App\Tests\DummySourceQuery\SourceDb\FindAllDummySourceQuery;
use App\Tests\Integration\SourceDbKernelTestCase;

final class SourceDbSourceQueryFactoryTest extends SourceDbKernelTestCase
{
    /**
     * @var SourceDbDtoHydrator
     */
    private $hydrator;

    /**
     * @var SourceDbSourceQueryFactory
     */
    private $queryFactory;

    public static function setUpBeforeClass()
    {
        self::$testTable = FindAllDummySourceQuery::$testTable;
        self::$dummyData = FindAllDummySourceQuery::$dummyData;
        parent::setUpBeforeClass();
        self::bootKernel();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->hydrator = self::$container->get(SourceDbDtoHydrator::class);
        $this->queryFactory = self::$container->get(SourceDbSourceQueryFactory::class);
    }

    public function testCreateFromDto()
    {
        $sourceQuerier = new SourceQuerier();
        $sourceQuerier->setClassName(FindAllDummySourceQuery::class);
        $sourceQuerier->setInterfaceName(FindAllDummySourceQueryInterface::class);

        $tablePrefix = '';

        $sourceQuery = $this->queryFactory->createFromDto(
            self::$sourceDbDto, $sourceQuerier, $tablePrefix
        );

        $this->assertInstanceOf(SourceQueryInterface::class, $sourceQuery);

        $data = $sourceQuery->execute();
        $this->assertIsArray($data);
        $this->assertEquals(self::$dummyData, $data);
    }

    public function testCreateFromModel()
    {
        $sourceDb = $this->hydrator->createModel(self::$sourceDbDto);

        $sourceQuerier = new SourceQuerier();
        $sourceQuerier->setClassName(FindAllDummySourceQuery::class);
        $sourceQuerier->setInterfaceName(FindAllDummySourceQueryInterface::class);

        $tablePrefix = '';

        $sourceQuery = $this->queryFactory->createFromModel(
            $sourceDb, $sourceQuerier, $tablePrefix
        );

        $this->assertInstanceOf(SourceQueryInterface::class, $sourceQuery);

        $data = $sourceQuery->execute();
        $this->assertIsArray($data);
        $this->assertEquals(self::$dummyData, $data);
    }
}
