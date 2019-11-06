<?php

namespace App\Infrastructure\SourceAccess\Method\SourceDb;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\SourceAccess\Method\SourceDbException;
use App\Core\Application\SourceAccess\Method\SourceDbConnectionInterface;
use Exception;
use SafeMySQL;

final class SafeMySQLSourceDbConnection implements SourceDbConnectionInterface
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
            $data = $this->safeMySQL->getAll($query, ...$args);
            if (empty($data)) {
                return false;
            }

            return $data;
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
            $data = $this->safeMySQL->getInd($index, $query, ...$args);
            if (empty($data)) {
                return false;
            }

            return $data;
        } catch (Exception $e) {
            throw new SourceDbException($e->getMessage(), $e->getCode());
        }
    }

    public function getIndCol(string $index, string $query, ...$args)
    {
        try {
            $data = $this->safeMySQL->getIndCol($index, $query, ...$args);
            if (empty($data)) {
                return false;
            }

            return $data;
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
        return $this->safeMySQL->whiteList($input, $allowed, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function filterArray(array $input, array $allowed)
    {
        // implemented manually
        // not calling SafeMySQL::filterArray due to buggy code
        foreach ($input as $key => $value) {
            if (!in_array($value, $allowed)) {
                unset($input[$key]);
            }
        }

        return $input;
    }

    /**
     * {@inheritdoc}
     */
    public function lastQuery()
    {
        try {
            return $this->safeMySQL->lastQuery();
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStats()
    {
        return $this->safeMySQL->getStats();
    }
}
