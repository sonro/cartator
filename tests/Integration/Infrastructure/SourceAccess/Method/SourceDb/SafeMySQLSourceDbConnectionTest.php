<?php

namespace App\Integration\Infrastructure\SourceAccess\Method\SourceDb;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;
use App\Core\Application\SourceAccess\Method\SourceDbException;
use App\Infrastructure\SourceAccess\Method\SourceDb\SafeMySQLSourceDbConnection;
use App\Tests\Integration\SourceDbTestCase;
use mysqli_result;

final class SafeMySQLSourceDbConnectionTest extends SourceDbTestCase
{
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

        new SafeMySQLSourceDbConnection($badSourceDbDto);
    }

    public function testCreateGoodConnection()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);
        $this->assertNull($conn->getStats());
    }

    public function testQuery()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

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
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

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
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

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

        $conn->query('INSERT INTO ?n (name) VALUES (?s)', self::$testTable, 'test_name_test');
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
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $expectedId = 0;
        $actualId = $conn->insertId();
        $this->assertEquals($expectedId, $actualId);

        $conn->query('INSERT INTO ?n (name) VALUES (?s)', self::$testTable, 'test_name_test');
        $expectedId = count(self::$dummyData) + 1;
        $actualId = $conn->insertId();
        $this->assertEquals($expectedId, $actualId);
    }

    public function testNumRows()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $result = $conn->query('SELECT * FROM ?n', self::$testTable);
        $expectedCount = count(self::$dummyData);
        $actualCount = $conn->numRows($result);
        $this->assertEquals($expectedCount, $actualCount);

        $result = $conn->query('SELECT * FROM ?n WHERE id = ?i', self::$testTable, 500);
        $expectedCount = 0;
        $actualCount = $conn->numRows($result);
        $this->assertEquals($expectedCount, $actualCount);
    }

    public function testFree()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $result = $conn->query('SELECT * FROM ?n', self::$testTable);
        $conn->free($result);

        $this->expectException(SourceDbException::class);
        $conn->free($result);
    }

    public function testFetchAfterFree()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $result = $conn->query('SELECT * FROM ?n', self::$testTable);
        $conn->free($result);

        $this->expectException(SourceDbException::class);
        $conn->fetch($result);
    }

    public function testNumRowsAfterFree()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $result = $conn->query('SELECT * FROM ?n', self::$testTable);
        $conn->free($result);

        $this->expectException(SourceDbException::class);
        $conn->numRows($result);
    }

    public function testGetOne()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $sql = 'SELECT name FROM ?n WHERE id=?i';

        $name = $conn->getOne($sql, self::$testTable, 1);
        $this->assertEquals(self::$dummyData[0], $name);

        $name = $conn->getOne($sql, self::$testTable, 500);
        $this->assertFalse($name);

        $this->expectException(SourceDbException::class);
        $sql = 'SELECT bad FROM ?n WHERE id=?i';
        $conn->getOne($sql, self::$testTable, 1);
    }

    public function testGetRow()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $sql = 'SELECT id, name FROM ?n WHERE id=?i';

        $data = $conn->getRow($sql, self::$testTable, 1);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertEquals(1, $data['id']);

        $data = $conn->getRow($sql, self::$testTable, 500);
        $this->assertFalse($data);

        $this->expectException(SourceDbException::class);
        $conn->getRow($sql, 'bad_table', 1);
    }

    public function testGetCol()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $sql = 'SELECT id FROM ?n WHERE name LIKE ?s';

        $data = $conn->getCol($sql, self::$testTable, 'test%');
        $this->assertIsArray($data);
        $this->assertEquals(count(self::$dummyData), count($data));

        $data = $conn->getCol($sql, self::$testTable, 'test_name_500');
        $this->assertFalse($data);

        $this->expectException(SourceDbException::class);
        $conn->getCol($sql, 'bad_table', 1);
    }

    public function testGetAll()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $data = $conn->getAll('SELECT * FROM ?n', self::$testTable);
        foreach (self::$dummyData as $index => $dummyName) {
            $this->assertEquals($dummyName, $data[$index]['name']);
        }

        $data = $conn->getAll('SELECT * FROM ?n WHERE id>?i', self::$testTable, 500);
        $this->assertFalse($data);

        $this->expectException(SourceDbException::class);
        $data = $conn->getAll('SELECT * FROM ?n WHERE id>?i', 'bad_table', 500);
    }

    public function testGetInd()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $data = $conn->getInd('name', 'SELECT * FROM ?n', self::$testTable);
        $this->assertIsArray($data);
        foreach (self::$dummyData as $name) {
            $this->assertArrayHasKey($name, $data);
        }

        $data = $conn->getInd('id', 'SELECT id FROM ?n WHERE id > ?i', self::$testTable, 500);
        $this->assertFalse($data);

        $this->expectException(SourceDbException::class);
        $data = $conn->getInd('bang', 'SELECT * FROM ?n', self::$testTable);
    }

    public function testGetIndCol()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $sql = 'SELECT * FROM ?n WHERE id > ?i';

        $data = $conn->getIndCol('id', $sql, self::$testTable, 0);
        $this->assertIsArray($data);
        $limit = count(self::$dummyData);
        for ($i = 0; $i < $limit; ++$i) {
            $this->assertEquals(self::$dummyData[$i], $data[$i + 1]);
        }

        $data = $conn->getIndCol('id', $sql, self::$testTable, 500);
        $this->assertFalse($data);

        $this->expectException(SourceDbException::class);
        $data = $conn->getInd('bang', $sql, self::$testTable);
    }

    public function testParse()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $query = $conn->parse(' AND id < ?i', 500);
        $this->assertEquals(' AND id < 500', $query);

        $this->expectException(SourceDbException::class);
        $conn->parse(' AND id < ?i');
    }

    public function testParseWithResult()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $whereIdIsLow = $conn->parse(' AND id < ?i', 2);
        $data = $conn->getAll(
            'SELECT * FROM ?n WHERE name LIKE ?s ?p',
            self::$testTable,
            'test_name%',
            $whereIdIsLow
        );

        $this->assertEquals(1, count($data));
    }

    public function testWhiteList()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $allowedValues = [
            'wallace',
            'gromit',
        ];

        $order = $conn->whiteList('cheese', $allowedValues);
        $this->assertFalse($order);

        $order = $conn->whiteList('wallace', $allowedValues);
        $this->assertEquals('wallace', $order);

        $order = $conn->whiteList('cheese', $allowedValues, 'gromit');
        $this->assertEquals('gromit', $order);
    }

    public function testFilterArray()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $allowedValues = [
            'wallace',
            'gromit',
            'shawn',
        ];

        $actualValues = [
            'wallace',
            'barry',
            'steve',
        ];
        $filtered = $conn->filterArray($actualValues, $allowedValues);
        $this->assertIsArray($filtered);
        $this->assertEquals(['wallace'], $filtered);

        $actualValues = [
            'bing',
            'barry',
            'scott',
        ];
        $filtered = $conn->filterArray($actualValues, $allowedValues);
        $this->assertIsArray($filtered);
        $this->assertEmpty($filtered);
    }

    public function testLastQuery()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $lastQuery = $conn->lastQuery();
        $this->assertNull($lastQuery);

        $sql = 'SELECT * FROM ?n';
        $parsedQuery = 'SELECT * FROM `'.self::$testTable.'`';

        $conn->getAll($sql, self::$testTable);
        $lastQuery = $conn->lastQuery();
        $this->assertEquals($parsedQuery, $lastQuery);

        $sql .= 'WHERE id = ?i';
        $parsedQuery .= 'WHERE id = 1';
        $conn->getOne($sql, self::$testTable, 1);
        $lastQuery = $conn->lastQuery();
        $this->assertEquals($parsedQuery, $lastQuery);
    }

    public function testGetStats()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $conn->getAll('SELECT * FROM ?n', self::$testTable);
        $conn->getOne('SELECT * FROM ?n WHERE id > ?i', self::$testTable, 500);
        $conn->getOne('SELECT * FROM ?n WHERE id = ?i', self::$testTable, 1);

        $stats = $conn->getStats();
        $this->assertIsArray($stats);
        $this->assertEquals(3, count($stats));
        $this->assertEquals(
            'SELECT * FROM `'.self::$testTable.'`',
            $stats[0]['query']
        );
    }

    public function testBadStats()
    {
        $conn = new SafeMySQLSourceDbConnection(self::$sourceDbDto);

        $stats = $conn->getStats();
        $this->assertNull($stats);

        $sql = 'SELECT * FROM unknown_table';

        try {
            $conn->getAll($sql);
        } catch (SourceDbException $e) {
            $stats = $conn->getStats();
        }

        $dbName = self::$sourceDbDto->getDb();

        $this->assertNotNull($stats);
        $this->assertEquals($sql, $stats[0]['query']);
        $this->assertArrayHasKey('error', $stats[0]);
        $this->assertEquals(
            "Table '$dbName.unknown_table' doesn't exist",
            $stats[0]['error']
        );
    }
}
