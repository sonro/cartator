<?php

namespace App\Core\Application\SourceAccess\SourceQuery;

interface SourceQueryInterface
{
    public function execute(): array;
}
