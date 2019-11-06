<?php

namespace App\Core\Application\DataTransfer\Hydrator;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\Service\DbUserService;
use App\Core\Domain\Resource\Model\SourceDb\DbHost;
use App\Core\Domain\Resource\Model\SourceDb\DbUser;
use App\Core\Domain\Resource\Model\SourceDb\SourceDb;

final class SourceDbDtoHydrator
{
    /**
     * @var DbUserService
     */
    private $dbUserService;

    public function __construct(DbUserService $dbUserService)
    {
        $this->dbUserService = $dbUserService;
    }

    public function createSourceDbDto(SourceDb $sourceDb): SourceDbDto
    {
        $host = $sourceDb->getDbHost()->getAddress();
        $port = $sourceDb->getDbHost()->getPort();
        $user = $this->dbUserService->getPlainUsername($sourceDb->getDbUser());
        $pass = $this->dbUserService->getPlainPassword($sourceDb->getDbUser());
        $db = $sourceDb->getDbName();
        $charset = $sourceDb->getDbCharset();

        return new SourceDbDto($host, $port, $user, $pass, $db, $charset);
    }

    public function createModel(SourceDbDto $sourceDbDto): SourceDb
    {
        $host = new DbHost();
        $host->setAddress($sourceDbDto->getHost());
        $host->setPort($sourceDbDto->getPort());

        $user = new DbUser();
        $user->setDbHost($host);
        $this->dbUserService->encodeUsername($user, $sourceDbDto->getUser());
        $this->dbUserService->encodePassword($user, $sourceDbDto->getPass());

        $db = new SourceDb();
        $db->setDbCharset($sourceDbDto->getCharset());
        $db->setDbName($sourceDbDto->getDb());
        $db->setDbUser($user);
        $db->setDbHost($host);

        return $db;
    }
}
