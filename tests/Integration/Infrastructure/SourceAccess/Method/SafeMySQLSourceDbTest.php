<?php

namespace App\Integration\Infrastructure\SourceAccess\Method;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\SourceAccess\Method\SourceDbException;
use App\Infrastructure\SourceAccess\Method\SourceDb\SafeMySQLSourceDb;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;

final class SafeMySQLSourceDbTest extends TestCase
{
    /**
     * @var SourceDbDto
     */
    private static $sourceDbDto;

    /**
     * @var string
     */
    private static $testTable = 'test_table';

    /**
     * @var PDO|null
     */
    private static $pdoConnection = null;

    public function testCreateBadConnection()
    {
        $this->expectException(SourceDbException::class);
        $badSourceDbDto = new SourceDbDto(
            '127.0.0.1',
            3306,
            'unkown_user',
            'wrong_password',
            'not-a-database',
            'utf8'
        );

        new SafeMySQLSourceDb($badSourceDbDto);
    }

    public function testCreateGoodConnection()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);
        $this->assertNull($conn->getStats());
    }

    public static function setUpBeforeClass()
    {
        self::$sourceDbDto = new SourceDbDto(
            $_ENV['TEST_SOURCE_DB_HOST'],
            $_ENV['TEST_SOURCE_DB_PORT'],
            $_ENV['TEST_SOURCE_DB_USER'],
            $_ENV['TEST_SOURCE_DB_PASS'],
            'source_db_test',
            $_ENV['TEST_SOURCE_DB_CHARSET']
        );

        self::loadDb();
    }

    public static function tearDownAfterClass()
    {
        $pdo = self::getConnection();
        $dbName = self::$sourceDbDto->getDb();
        $pdo->exec("DROP DATABASE IF EXISTS $dbName");
        self::$pdoConnection = null;
    }

    private static function loadDb()
    {
        $pdo = self::getConnection();
        $dbName = self::$sourceDbDto->getDb();
        $table = self::$testTable;

        $schema =
            "CREATE DATABASE IF NOT EXISTS $dbName;

            USE $dbName;

            DROP TABLE IF EXISTS $table;

            CREATE TABLE $table (
                id INT NOT NULL AUTO_INCREMENT,
                name VARCHAR(64) NOT NULL,
                PRIMARY KEY(id)
            );";

        $pdo->exec($schema);
    }

    private static function getConnection(): PDO
    {
        if (self::$pdoConnection === null) {
            $dbHost = self::$sourceDbDto->getHost();
            $dbUser = self::$sourceDbDto->getUser();
            $dbPass = self::$sourceDbDto->getPass();
            $dbPort = self::$sourceDbDto->getPort();
            $dbCharset = 'utf8mb4';

            $dsn = "mysql:host=$dbHost;charset=$dbCharset;port=$dbPort";
            $dbOptions = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                $pdo = new PDO($dsn, $dbUser, $dbPass, $dbOptions);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int) $e->getCode());
            }

            self::$pdoConnection = $pdo;
        }

        return self::$pdoConnection;
    }
}
