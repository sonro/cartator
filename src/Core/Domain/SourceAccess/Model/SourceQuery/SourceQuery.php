<?php

namespace App\Core\Domain\SourceAccess\Model\SourceQuery;

use App\Core\Domain\Resource\Model\Shared\AbstractDomainEntity;

final class SourceQuery extends AbstractDomainEntity
{
    /**
     * @var string
     */
    private $interfaceName;

    /**
     * @var string
     */
    private $className;

    /**
     * Get the value of interfaceName.
     *
     * @return string
     */
    public function getInterfaceName()
    {
        return $this->interfaceName;
    }

    /**
     * Set the value of interfaceName.
     *
     * @param string $interfaceName
     *
     * @return self
     */
    public function setInterfaceName(string $interfaceName)
    {
        $this->interfaceName = $interfaceName;

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
