<?php

namespace App\Core\Domain\Model\Installation;

use App\Core\Domain\Model\Shared\AbstractDomainEntity;
use App\Core\Domain\Model\Database\Database;

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
}
