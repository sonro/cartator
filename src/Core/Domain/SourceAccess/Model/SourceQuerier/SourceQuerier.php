<?php

namespace App\Core\Domain\SourceAccess\Model\SourceQuerier;

use App\Core\Domain\Shared\Model\AbstractStampableDomainEntity;
use App\Core\Domain\Resource\Model\SourceApp\SourceApp;
use App\Core\Domain\SourceAccess\Model\Shared\AccessorMethod;
use App\Core\Domain\SourceAccess\Model\DataType\DataType;

class SourceQuerier extends AbstractStampableDomainEntity
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
     * @var DataType
     */
    private $dataType;

    /**
     * @var SourceApp
     */
    private $sourceApp;

    /**
     * @var AccessorMethod
     */
    private $method;

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

    /**
     * Get the value of dataType.
     *
     * @return DataType
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Set the value of dataType.
     *
     * @param DataType $dataType
     *
     * @return self
     */
    public function setDataType(DataType $dataType)
    {
        $this->dataType = $dataType;

        return $this;
    }

    /**
     * Get the value of sourceApp.
     *
     * @return SourceApp
     */
    public function getSourceApp()
    {
        return $this->sourceApp;
    }

    /**
     * Set the value of sourceApp.
     *
     * @param SourceApp $sourceApp
     *
     * @return self
     */
    public function setSourceApp(SourceApp $sourceApp)
    {
        $this->sourceApp = $sourceApp;

        return $this;
    }

    /**
     * Get the value of method.
     *
     * @return AccessorMethod
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the value of method.
     *
     * @param AccessorMethod $method
     *
     * @return self
     */
    public function setMethod(AccessorMethod $method)
    {
        $this->method = $method;

        return $this;
    }
}
