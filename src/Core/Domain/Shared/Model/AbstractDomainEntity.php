<?php

namespace App\Core\Domain\Shared\Model;

/**
 * Base class for domain entities.
 *
 * Includes an Id
 */
abstract class AbstractDomainEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Get the value of id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
