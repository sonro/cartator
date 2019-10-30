<?php

namespace App\Core\Domain\Resource\Model\Installation;

use App\Core\Domain\Resource\Model\Shared\AbstractDomainEntity;
use App\Core\Domain\Resource\Model\SourceAppVersion\SourceAppVersion;
use App\Core\Domain\Resource\Model\SourceDb\SourceDb;

final class Installation extends AbstractDomainEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var SourceDb|null
     */
    private $sourceDb;

    /**
     * @var string
     */
    private $dbTablePrefix;

    /**
     * @var SourceAppVersion
     */
    private $sourceAppVersion;

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

    public function hasSourceDb(): bool
    {
        if ($this->sourceDb === null) {
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

    /**
     * Get the value of sourceDb.
     *
     * @return SourceDb|null
     */
    public function getSourceDb()
    {
        return $this->sourceDb;
    }

    /**
     * Set the value of sourceDb.
     *
     * @param SourceDb|null $sourceDb
     *
     * @return self
     */
    public function setSourceDb($sourceDb)
    {
        $this->sourceDb = $sourceDb;

        return $this;
    }

    /**
     * Get the value of sourceAppVersion.
     *
     * @return SourceAppVersion
     */
    public function getSourceAppVersion()
    {
        return $this->sourceAppVersion;
    }

    /**
     * Set the value of sourceAppVersion.
     *
     * @param SourceAppVersion $sourceAppVersion
     *
     * @return self
     */
    public function setSourceAppVersion(SourceAppVersion $sourceAppVersion)
    {
        $this->sourceAppVersion = $sourceAppVersion;

        return $this;
    }
}
