<?php

namespace App\Core\Domain\Resource\Model\SourceDb;

use App\Core\Domain\Shared\Model\AbstractStampableDomainEntity;

class SourceDb extends AbstractStampableDomainEntity
{
    /**
     * @var string
     */
    private $dbName;

    /**
     * @var DbUser
     */
    private $dbUser;

    /**
     * @var DbHost
     */
    private $dbHost;

    /**
     * @return string
     */
    private $dbCharset = 'utf8';

    /**
     * Get the value of dbName.
     *
     * @return string
     */
    public function getDbName(): string
    {
        return $this->dbName;
    }

    /**
     * Set the value of dbName.
     *
     * @return self
     */
    public function setDbName(string $dbName): self
    {
        $this->dbName = $dbName;

        return $this;
    }

    /**
     * Get the value of dbUser.
     *
     * @return DbUser
     */
    public function getDbUser(): DbUser
    {
        return $this->dbUser;
    }

    /**
     * Set the value of dbUser.
     *
     * @param DbUser $dbUser
     *
     * @return self
     */
    public function setDbUser(DbUser $dbUser): self
    {
        $this->dbUser = $dbUser;

        return $this;
    }

    /**
     * Get the value of dbCharset.
     */
    public function getDbCharset()
    {
        return $this->dbCharset;
    }

    /**
     * Set the value of dbCharset.
     *
     * @return self
     */
    public function setDbCharset($dbCharset)
    {
        $this->dbCharset = $dbCharset;

        return $this;
    }

    /**
     * Get the value of dbHost.
     *
     * @return DbHost
     */
    public function getDbHost()
    {
        return $this->dbHost;
    }

    /**
     * Set the value of dbHost.
     *
     * @param DbHost $dbHost
     *
     * @return self
     */
    public function setDbHost(DbHost $dbHost)
    {
        $this->dbHost = $dbHost;

        return $this;
    }
}
