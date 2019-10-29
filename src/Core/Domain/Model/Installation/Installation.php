<?php

namespace App\Core\Domain\Model\Installation;

use App\Core\Domain\Model\Shared\AbstractDomainEntity;
use App\Core\Domain\Model\Database\Database;
use App\Core\Domain\Model\Software\Software;

final class Installation extends AbstractDomainEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Database|null
     */
    private $database;

    /**
     * @var string
     */
    private $dbTablePrefix;

    /**
     * @var Software
     */
    private $software;

    /**
     * @var string
     */
    private $urlBase;

    /**
     * @var string
     */
    private $urlAdmin;

    /**
     * @var bool
     */
    private $multistore = false;

    /**
     * @var bool
     */
    private $registered = false;

    /**
     * @var bool
     */
    private $active = true;

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name.
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of database.
     *
     * @return Database|null
     */
    public function getDatabase(): ?Database
    {
        return $this->database;
    }

    /**
     * Set the value of database.
     *
     * @param Database|null $database
     *
     * @return self
     */
    public function setDatabase(?Database $database): self
    {
        $this->database = $database;

        return $this;
    }

    public function hasDatabase(): bool
    {
        if ($this->database === null) {
            return false;
        }

        return true;
    }

    /**
     * Get the value of dbTablePrefix.
     *
     * @return string
     */
    public function getDbTablePrefix(): string
    {
        return $this->dbTablePrefix;
    }

    /**
     * Set the value of dbTablePrefix.
     *
     * @param string $dbTablePrefix
     *
     * @return self
     */
    public function setDbTablePrefix(string $dbTablePrefix): self
    {
        $this->dbTablePrefix = $dbTablePrefix;

        return $this;
    }

    /**
     * Get the value of software.
     *
     * @return Software
     */
    public function getSoftware(): Software
    {
        return $this->software;
    }

    /**
     * Set the value of software.
     *
     * @param Software $software
     *
     * @return self
     */
    public function setSoftware(Software $software): self
    {
        $this->software = $software;

        return $this;
    }

    /**
     * Get the value of multistore.
     *
     * @return bool
     */
    public function isMultistore(): bool
    {
        return $this->multistore;
    }

    /**
     * Set the value of multistore.
     *
     * @param bool $multistore
     *
     * @return self
     */
    public function setMultistore(bool $multistore): self
    {
        $this->multistore = $multistore;

        return $this;
    }

    /**
     * Get the value of urlBase.
     *
     * @return string
     */
    public function getUrlBase(): string
    {
        return $this->urlBase;
    }

    /**
     * Set the value of urlBase.
     *
     * @param string $urlBase
     *
     * @return self
     */
    public function setUrlBase(string $urlBase): self
    {
        $this->urlBase = $urlBase;

        return $this;
    }

    /**
     * Get the value of urlAdmin.
     *
     * @return string
     */
    public function getUrlAdmin(): string
    {
        return $this->urlAdmin;
    }

    /**
     * Set the value of urlAdmin.
     *
     * @param string $urlAdmin
     *
     * @return self
     */
    public function setUrlAdmin(string $urlAdmin): self
    {
        $this->urlAdmin = $urlAdmin;

        return $this;
    }

    /**
     * Get the value of registered.
     *
     * @return bool
     */
    public function isRegistered(): bool
    {
        return $this->registered;
    }

    /**
     * Set the value of registered.
     *
     * @param bool $registered
     *
     * @return self
     */
    public function setRegistered(bool $registered): self
    {
        $this->registered = $registered;

        return $this;
    }

    /**
     * Get the value of active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Set the value of active.
     *
     * @param bool $active
     *
     * @return self
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
