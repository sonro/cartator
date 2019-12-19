<?php

namespace App\Core\Domain\Resource\Model\SourceDb;

use App\Core\Domain\Shared\Model\AbstractStampableDomainEntity;

class DbHost extends AbstractStampableDomainEntity
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $port = 3306;

    /**
     * Get the value of address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address.
     *
     * @param string $address
     *
     * @return self
     */
    public function setAddress(string $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of port.
     *
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the value of port.
     *
     * @param int $port
     *
     * @return self
     */
    public function setPort(int $port)
    {
        $this->port = $port;

        return $this;
    }
}
