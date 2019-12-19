<?php

namespace App\Core\Domain\Resource\Model\SourceDb;

use App\Core\Domain\Shared\Model\AbstractStampableDomainEntity;

class DbUser extends AbstractStampableDomainEntity
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var DbHost
     */
    private $dbHost;

    /**
     * Get the value of username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username.
     *
     * @param string $username
     *
     * @return self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password.
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

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
