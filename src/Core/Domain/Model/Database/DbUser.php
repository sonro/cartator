<?php

namespace App\Core\Domain\Model\Database;

use App\Core\Domain\Model\Shared\AbstractDomainEntity;

final class DbUser extends AbstractDomainEntity
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
}
