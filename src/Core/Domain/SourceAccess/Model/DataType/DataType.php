<?php

namespace App\Core\Domain\SourceAccess\Model\DataType;

use App\Core\Domain\Shared\Model\AbstractStampableDomainEntity;

class DataType extends AbstractStampableDomainEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $className;

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of className.
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Set the value of className.
     *
     * @param string $className
     *
     * @return self
     */
    public function setClassName(string $className)
    {
        $this->className = $className;

        return $this;
    }
}
