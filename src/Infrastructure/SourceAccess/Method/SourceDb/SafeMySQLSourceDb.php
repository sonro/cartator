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
        try {
            return $this->safeMySQL->query($query, ...$args);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($result, $mode = self::RESULT_ASSOC)
    {
        try {
            return $this->safeMySQL->fetch($result, $mode);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
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
        try {
            return $this->safeMySQL->numRows($result);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function free($result)
    {
        try {
            $this->safeMySQL->free($result);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOne(string $query, ...$args)
    {
        try {
            return $this->safeMySQL->getOne($query, ...$args);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRow(string $query, ...$args)
    {
        try {
            $row = $this->safeMySQL->getRow($query, ...$args);
            if ($row === null) {
                return false;
            }

            return $row;
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCol(string $query, ...$args)
    {
        try {
            $col = $this->safeMySQL->getCol($query, ...$args);
            if (empty($col)) {
                return false;
            }

            return $col;
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(string $query, ...$args)
    {
        try {
            return $this->safeMySQL->getAll($query, ...$args);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getInd(string $index, string $query, ...$args)
    {
        try {
            return $this->safeMySQL->getInd($index, $query, ...$args);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    public function getIndCol(string $index, string $query, ...$args)
    {
        try {
            return $this->safeMySQL->getIndCol($query, ...$args);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function parse(string $query, ...$args)
    {
        try {
            return $this->safeMySQL->parse($query, ...$args);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    public function whiteList(string $input, array $allowed, $default = false)
    {
        try {
            return $this->safeMySQL->whiteList($input, $allowed, $default);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function filterArray(array $input, array $allowed)
    {
        try {
            return $this->safeMySQL->filterArray($input, $allowed);
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
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
