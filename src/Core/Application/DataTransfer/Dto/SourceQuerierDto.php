<?php

namespace App\Core\Application\DataTransfer\Dto;

final class SourceQuerierDto
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $interfaceName;

    /**
     * @var string
     */
    private $methodName;

    /**
     * @var string
     */
    private $sourceAppName;

    /**
     * @var string
     */
    private $dataTypeName;

    public function __construct(
        string $className,
        string $interfaceName,
        string $methodName,
        string $sourceAppName,
        string $dataTypeName
    ) {
        $this->className = $className;
        $this->interfaceName = $interfaceName;
        $this->methodName = $methodName;
        $this->sourceAppName = $sourceAppName;
        $this->dataTypeName = $dataTypeName;
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
     * Get the value of interfaceName.
     *
     * @return string
     */
    public function getInterfaceName()
    {
        return $this->interfaceName;
    }

    /**
     * Get the value of methodName.
     *
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * Get the value of sourceAppName.
     *
     * @return string
     */
    public function getSourceAppName()
    {
        return $this->sourceAppName;
    }

    /**
     * Get the value of dataTypeName.
     *
     * @return string
     */
    public function getDataTypeName()
    {
        return $this->dataTypeName;
    }
}
