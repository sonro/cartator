<?php

namespace App\Core\Application\DataTransfer\Dto;

final class SourceDbDto
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var string
     */
    private $db;

    /**
     * @var string
     */
    private $charset;

    public function __construct(
        string $host,
        int $port,
        string $user,
        string $pass,
        string $db,
        string $charset
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
        $this->charset = $charset;
    }

    /**
     * Get the value of host.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
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
     * Get the value of user.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the value of pass.
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Get the value of db.
     *
     * @return string
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Get the value of charset.
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }
}
