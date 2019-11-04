<?php

namespace App\Core\Application\Service;

use App\Core\Application\Util\Encoder\SensitiveStringEncoderInterface;
use App\Core\Domain\Resource\Model\SourceDb\DbUser;

final class DbUserService
{
    /**
     * @var SensitiveStringEncoderInterface
     */
    private $encoder;

    public function __construct(
        SensitiveStringEncoderInterface $encoder
    ) {
        $this->encoder = $encoder;
    }

    /**
     * Get the plain unencoded username of the DbUser.
     *
     * @param DbUser $dbUser
     *
     * @return string
     */
    public function getPlainUsername(DbUser $dbUser): string
    {
        return $this->encoder->decode($dbUser->getUsername());
    }

    /**
     * Get the plain unencoded password of the DbUser.
     *
     * @param DbUser $dbUser
     *
     * @return string
     */
    public function getPlainPassword(DbUser $dbUser): string
    {
        return $this->encoder->decode($dbUser->getPassword());
    }

    /**
     * Set the password of a DbUser with an encoded password.
     *
     * @param DbUser $dbUser
     * @param string $plainPassword
     *
     * @return DbUser
     */
    public function encodePassword(DbUser $dbUser, string $plainPassword): DbUser
    {
        return $dbUser->setPassword($this->encoder->encode($plainPassword));
    }

    /**
     * Set the username of a DbUser with an encoded username.
     *
     * @param DbUser $dbUser
     * @param string $plainUsername
     *
     * @return DbUser
     */
    public function encodeUsername(DbUser $dbUser, string $plainUsername): DbUser
    {
        return $dbUser->setUsername($this->encoder->encode($plainUsername));
    }
}
