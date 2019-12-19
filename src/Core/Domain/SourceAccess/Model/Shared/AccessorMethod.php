<?php

namespace App\Core\Domain\SourceAccess\Model\Shared;

class AccessorMethod
{
    const CARTATOR_API = 'cartator_api';
    const SOURCE_DB = 'source_db';
    const SOURCE_API = 'source_api';
    const CUSTOM = 'custom';

    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $establishedMethods = [
            self::CARTATOR_API,
            self::SOURCE_DB,
            self::SOURCE_API,
            self::CUSTOM,
        ];

        if (!in_array($name, $establishedMethods)) {
            throw new InvalidArgumentException('Invalid method name');
        }
        $this->name = $name;
    }

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
