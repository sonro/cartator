<?php

namespace App\Core\Domain\Model\Database;

use App\Core\Domain\Model\Shared\AbstractDomainEntity;

final class Database extends AbstractDomainEntity
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
     * @var string
     */
    private $dbHost;

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
     * Get the value of dbHost.
     *
     * @return string
     */
    public function getDbHost(): string
    {
        return $this->dbHost;
    }

    /**
     * Set the value of dbHost.
     *
     * @param string $dbHost
     *
     * @return self
     */
    public function setDbHost(string $dbHost): self
    {
        $this->dbHost = $dbHost;

        return $this;
    }
}
