<?php

namespace App\Infrastructure\SourceAccess\Method\SourceDb;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\SourceAccess\Method\SourceDbException;
use App\Core\Application\SourceAccess\Method\SourceDbInterface;
use Exception;
use SafeMySQL;

final class SafeMySQLSourceDb implements SourceDbInterface
{
    /**
     * @var SafeMySQL
     */
    private $safeMySQL;

    public function __construct(SourceDbDto $sourceDbDto)
    {
        $options = [
            'host' => $sourceDbDto->getHost(),
            'user' => $sourceDbDto->getUser(),
            'pass' => $sourceDbDto->getPass(),
            'db' => $sourceDbDto->getDb(),
            'port' => $sourceDbDto->getPort(),
            'charset' => $sourceDbDto->getCharset(),
        ];

        try {
            $this->safeMySQL = new SafeMySQL($options);
        } catch (Exception $e) {
            throw new SourceDbException(
                'Unable to connect to source database', $e->getCode(), $e
           );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function query(string $query, ...$args)
    {
        return $this->safeMySQL->query($query, ...$args);
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($result, $mode = self::RESULT_ASSOC)
    {
        return $this->safeMySQL->fetch($result, $mode);
    }

    /**
     * {@inheritdoc}
     */
    public function affectedRows()
    {
        return $this->safeMySQL->affectedRows();
    }

    /**
     * {@inheritdoc}
     */
    public function insertId()
    {
        return $this->safeMySQL->insertId();
    }

    /**
     * {@inheritdoc}
     */
    public function numRows($result)
    {
        return $this->safeMySQL->numRows($result);
    }

    /**
     * {@inheritdoc}
     */
    public function free($result)
    {
        return $this->safeMySQL->free($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getOne(string $query, ...$args)
    {
        return $this->safeMySQL->getOne($query, ...$args);
    }

    /**
     * {@inheritdoc}
     */
    public function getRow(string $query, ...$args)
    {
        return $this->safeMySQL->getRow($query, ...$args);
    }

    /**
     * {@inheritdoc}
     */
    public function getCol(string $query, ...$args)
    {
        return $this->safeMySQL->getCol($query, ...$args);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(string $query, ...$args)
    {
        return $this->safeMySQL->getAll($query, ...$args);
    }

    /**
     * {@inheritdoc}
     */
    public function getInd(string $index, string $query, ...$args)
    {
        return $this->safeMySQL->getInd($index, $query, ...$args);
    }

    public function getIndCol(string $index, string $query, ...$args)
    {
        return $this->safeMySQL->getIndCol($query, ...$args);
    }

    /**
     * {@inheritdoc}
     */
    public function parse(string $query, ...$args)
    {
        return $this->safeMySQL->parse($query, ...$args);
    }

    public function whiteList(string $input, array $allowed, $default = false)
    {
        return $this->safeMySQL->whiteList($input, $allowed, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function filterArray(array $input, array $allowed)
    {
        return $this->safeMySQL->filterArray($input, $allowed);
    }

    public function lastQuery()
    {
        return $this->safeMySQL->lastQuery();
    }

    /**
     * {@inheritdoc}
     */
    public function getStats()
    {
        return $this->safeMySQL->getStats();
    }
}
