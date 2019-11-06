<?php

namespace App\Core\Application\SourceAccess\SourceQuery\Factory;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\DataTransfer\Hydrator\SourceDbDtoHydrator;
use App\Core\Application\SourceAccess\Method\SourceDbConnectionFactoryInterface;
use App\Core\Application\SourceAccess\SourceQuery\SourceQueryInterface;
use App\Core\Domain\Resource\Model\SourceDb\SourceDb;
use App\Core\Domain\SourceAccess\Model\SourceQuerier\SourceQuerier;

final class SourceDbSourceQueryFactory
{
    /**
     * @var SourceDbDtoHydrator
     */
    private $hydrator;

    /**
     * @var SourceDbConnectionFactoryInterface
     */
    private $dbFactory;

    public function __construct(
        SourceDbDtoHydrator $hydrator,
        SourceDbConnectionFactoryInterface $dbFactory
        ) {
        $this->hydrator = $hydrator;
        $this->dbFactory = $dbFactory;
    }

    public function createFromModel(
        SourceDb $sourceDb,
        SourceQuerier $sourceQuerier,
        string $tablePrefix
    ): SourceQueryInterface {
        $sourceDbDto = $this->hydrator->createSourceDbDto($sourceDb);

        return $this->createFromDto($sourceDbDto, $sourceQuerier, $tablePrefix);
    }

    public function createFromDto(
        SourceDbDto $sourceDbDto,
        SourceQuerier $sourceQuerier,
        string $tablePrefix
    ): SourceQueryInterface {
        $sourceDbConnection = $this->dbFactory->create($sourceDbDto);
        $sourceQueryClass = $sourceQuerier->getClassName();

        return new $sourceQueryClass($sourceDbConnection, $tablePrefix);
    }
}
