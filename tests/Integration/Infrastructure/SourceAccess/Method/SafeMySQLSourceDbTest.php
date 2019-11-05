<?php

namespace App\Integration\Infrastructure\SourceAccess\Method;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\SourceAccess\Method\SourceDbException;
use App\Infrastructure\SourceAccess\Method\SourceDb\SafeMySQLSourceDb;
use mysqli_result;
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

    /**
     * @var array
     */
    private static $dummyData = [
        'test_name_1',
        'test_name_2',
        'test_name_3',
    ];

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

    public function testQuery()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $result = $conn->query('SELECT * FROM ?n WHERE id=?i', self::$testTable, 1);
        $this->assertTrue(is_a($result, mysqli_result::class));
        $row = $result->fetch_row();
        $this->assertEquals(1, $row[0]);

        $result = $conn->query('DELETE FROM ?n WHERE id=?i', self::$testTable, 1);
        $this->assertTrue($result);

        $result = $conn->query('SELECT * FROM ?n WHERE id=?i', self::$testTable, 1);
        $this->assertTrue(is_a($result, mysqli_result::class));
        $row = $result->fetch_row();
        $this->assertNull($row);

        $this->expectException(SourceDbException::class);
        $result = $conn->query('SELECT * FROM ?n WHERE id=?i', 'unknown_table', 1);
    }

    public function testFetch()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $result = $conn->query('SELECT * FROM ?n', self::$testTable);
        $this->assertTrue(is_a($result, mysqli_result::class));

        $dummies = count(self::$dummyData);
        for ($i = 0; $i < $dummies; ++$i) {
            $row = $conn->fetch($result);
            $this->assertIsArray($row);
        }

        $row = $conn->fetch($result);
        $this->assertNull($row);
    }

    public function testAffectedRows()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $actualCount = 0;
        $affectedRows = $conn->affectedRows();
        $this->assertEquals($actualCount, $affectedRows);

        $conn->query('SELECT * FROM ?n', self::$testTable);
        $actualCount = count(self::$dummyData);
        $affectedRows = $conn->affectedRows();
        $this->assertEquals($actualCount, $affectedRows);

        $conn->query('DELETE FROM ?n WHERE id=?i', self::$testTable, 1);
        $actualCount = 1;
        $affectedRows = $conn->affectedRows();
        $this->assertEquals($actualCount, $affectedRows);

        $conn->query('INSERT INTO ?n (name) VALUES (?s)', self::$testTable, 'test_name_4');
        $actualCount = 1;
        $affectedRows = $conn->affectedRows();
        $this->assertEquals($actualCount, $affectedRows);

        $conn->query('SELECT * FROM ?n', self::$testTable);
        $actualCount = count(self::$dummyData);
        $affectedRows = $conn->affectedRows();
        $this->assertEquals($actualCount, $affectedRows);
    }

    public function testInsertId()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $expectedId = 0;
        $actualId = $conn->insertId();
        $this->assertEquals($expectedId, $actualId);

        $conn->query('INSERT INTO ?n (name) VALUES (?s)', self::$testTable, 'test_name_4');
        $expectedId = 4;
        $actualId = $conn->insertId();
        $this->assertEquals($expectedId, $actualId);
    }

    public function testNumRows()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $result = $conn->query('SELECT * FROM ?n', self::$testTable);
        $expectedCount = count(self::$dummyData);
        $actualCount = $conn->numRows($result);
        $this->assertEquals($expectedCount, $actualCount);

        $result = $conn->query('SELECT * FROM ?n WHERE id = ?i', self::$testTable, 4);
        $expectedCount = 0;
        $actualCount = $conn->numRows($result);
        $this->assertEquals($expectedCount, $actualCount);
    }

    public function testFree()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $result = $conn->query('SELECT * FROM ?n', self::$testTable);
        $conn->free($result);

        $this->expectException(SourceDbException::class);
        $conn->free($result);
    }

    public function testFetchAfterFree()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $result = $conn->query('SELECT * FROM ?n', self::$testTable);
        $conn->free($result);

        $this->expectException(SourceDbException::class);
        $conn->fetch($result);
    }

    public function testNumRowsAfterFree()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $result = $conn->query('SELECT * FROM ?n', self::$testTable);
        $conn->free($result);

        $this->expectException(SourceDbException::class);
        $conn->numRows($result);
    }

    public function testGetOne()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $sql = 'SELECT name FROM ?n WHERE id=?i';

        $name = $conn->getOne($sql, self::$testTable, 1);
        $this->assertEquals(self::$dummyData[0], $name);

        $name = $conn->getOne($sql, self::$testTable, 4);
        $this->assertFalse($name);

        $this->expectException(SourceDbException::class);
        $sql = 'SELECT bad FROM ?n WHERE id=?i';
        $conn->getOne($sql, self::$testTable, 1);
    }

    public function testGetRow()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $sql = 'SELECT id, name FROM ?n WHERE id=?i';

        $data = $conn->getRow($sql, self::$testTable, 1);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertEquals(1, $data['id']);

        $data = $conn->getRow($sql, self::$testTable, 5);
        $this->assertFalse($data);

        $this->expectException(SourceDbException::class);
        $conn->getRow($sql, 'bad_table', 1);
    }

    public function testGetCol()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $sql = 'SELECT id FROM ?n WHERE name LIKE ?s';

        $data = $conn->getCol($sql, self::$testTable, 'test%');
        $this->assertIsArray($data);
        $this->assertEquals(count(self::$dummyData), count($data));

        $data = $conn->getCol($sql, self::$testTable, 'test_name_7');
        $this->assertFalse($data);

        $this->expectException(SourceDbException::class);
        $conn->getCol($sql, 'bad_table', 1);
    }

    public function testGetAll()
    {
        $conn = new SafeMySQLSourceDb(self::$sourceDbDto);

        $result = $conn->getAll('SELECT * FROM ?n', self::$testTable);
        foreach (self::$dummyData as $index => $dummyName) {
            $this->assertEquals($dummyName, $result[$index]['name']);
        }

        $result = $conn->getAll('SELECT * FROM ?n WHERE id>?i', self::$testTable, 5);
        $this->assertFalse($result);
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

    protected function setUp()
    {
        $pdo = self::getConnection();
        $table = self::$testTable;
        $sql = "INSERT INTO $table (name) VALUES ";
        $dummies = count(self::$dummyData);
        while ($dummies-- > 1) {
            $sql .= '(?),';
        }
        $sql .= '(?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(self::$dummyData);
    }

    protected function tearDown()
    {
        $pdo = self::getConnection();
        $table = self::$testTable;
        $pdo->exec("TRUNCATE TABLE $table");
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
