<?php

namespace App\Infrastructure\SourceAccess\SourceQuery\SourceDb\Prestashop\Order;

use App\Core\Application\SourceAccess\Method\SourceDb\SourceDbSourceQueryTrait;
use App\Core\Application\SourceAccess\SourceQuery\DataType\Order\FindAllOrdersSourceQueryInterface;

final class FindAllOrdersSourceQuery implements FindAllOrdersSourceQueryInterface
{
    use SourceDbSourceQueryTrait;

    public function execute(): array
    {
        $sql = 'SELECT * FROM ?n';
        $table = $this->tablePrefix.'orders';

        return $this->sourceDb->getAll($sql, $table);
    }
}
