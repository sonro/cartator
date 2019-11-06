<?php

namespace App\Tests\DummySourceQuery\SourceDb;

use App\Core\Application\SourceAccess\Method\SourceDbSourceQueryTrait;
use App\Tests\DummySourceQuery\FindAllDummySourceQueryInterface;

final class FindAllDummySourceQuery implements FindAllDummySourceQueryInterface
{
    use SourceDbSourceQueryTrait;

    /**
     * @var string
     */
    public static $testTable = 'test_table';

    /**
     * @var array
     */
    public static $dummyData = [
        'test_name_1',
        'test_name_2',
        'test_name_3',
        'test_name_4',
        'test_name_5',
        'test_name_6',
    ];

    public function execute(): array
    {
        $sql = 'SELECT name FROM ?n';

        return $this->sourceDb->getCol($sql, self::$testTable);
    }
}
