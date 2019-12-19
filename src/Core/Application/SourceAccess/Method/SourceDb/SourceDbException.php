<?php

namespace App\Core\Application\SourceAccess\Method\SourceDb;

use Exception;

final class SourceDbException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }
}
