<?php

namespace App\Core\Domain\Resource\Model\Shared;

use DateTime;

/**
 * Base class for domain entities.
 *
 * Includes an Id and lifecycle methods
 */
abstract class AbstractDomainEntity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * Get the value of id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Trigger on entity creation.
     */
    public function setCreatedAtValue()
    {
        if ($this->createdAt === null) {
            $this->createdAt = new DateTime();
            $this->updatedAt = $this->createdAt;
        }
    }

    /**
     * Trigger on entity update.
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * Get the value of createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Get the value of updatedAt.
     *
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
