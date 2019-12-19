<?php

namespace App\Core\Domain\Shared\Model;

use DateTime;

/**
 * Base class for domain entities.
 *
 * Includes an Id and lifecycle methods
 */
abstract class AbstractStampableDomainEntity extends AbstractDomainEntity
{
    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $updatedAt;

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
