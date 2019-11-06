<?php

namespace App\Core\Application\SourceAccess\Method;

trait SourceDbSourceQueryTrait
{
    /**
     * @var SourceDbConnectionInterface
     */
    private $sourceDb;

    /**
     * @var string
     */
    private $tablePrefix;

    public function __construct(SourceDbConnectionInterface $sourceDb, string $tablePrefix)
    {
        $this->sourceDb = $sourceDb;
        $this->tablePrefix = $tablePrefix;
    }
}
