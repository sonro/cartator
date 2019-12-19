<?php

namespace App\Core\Domain\SourceAccess\Model\Accessor;

use App\Core\Domain\Shared\Model\AbstractStampableDomainEntity;
use App\Core\Domain\Resource\Model\SourceApp\SourceApp;
use App\Core\Domain\SourceAccess\Model\DataType\DataType;
use App\Core\Domain\SourceAccess\Model\Shared\AccessorMethod;
use App\Core\Domain\SourceAccess\Model\SourceQuerier\SourceQuerier;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Accessor extends AbstractStampableDomainEntity
{
    /**
     * @var AccessorMethod
     */
    private $method;

    /**
     * @var Collection
     */
    private $supportedDataTypes;

    /**
     * @var Collection
     */
    private $supportedSourceApps;

    /**
     * @var Collection
     */
    private $supportedSourceQueries;

    public function __construct()
    {
        $this->supportedSourceApps = new ArrayCollection();
        $this->supportedDataTypes = new ArrayCollection();
        $this->supportedSourceQueries = new ArrayCollection();
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

    /**
     * Get the of supportedDataTypes.
     *
     * @return Collection
     */
    public function getSupportedDataTypes()
    {
        return $this->supportedDataTypes;
    }

    /**
     * Add support for a DataType.
     *
     * @param DataType $dataType
     *
     * @return self
     */
    public function addSupportedDataType(DataType $dataType): self
    {
        if ($this->supportedDataTypes->contains($dataType)) {
            return $this;
        }

        $this->supportedDataTypes->add($dataType);

        return $this;
    }

    /**
     * Remove support for a DataType.
     *
     * @param DataType $dataType
     *
     * @return self
     */
    public function removeSupportedDataType(DataType $dataType): self
    {
        if ($this->supportedDataTypes->contains($dataType)) {
            $this->supportedDataTypes->removeElement($dataType);
        }

        return $this;
    }

    /**
     * Get the value of supportedSourceApps.
     *
     * @return Collection
     */
    public function getSupportedSourceApps()
    {
        return $this->supportedSourceApps;
    }

    /**
     * Add support for a SourceApp.
     *
     * @param SourceApp $sourceApp
     *
     * @return self
     */
    public function addSupportedSourceApp(SourceApp $sourceApp): self
    {
        if ($this->supportedSourceApps->contains($sourceApp)) {
            return $this;
        }

        $this->supportedSourceApps->add($sourceApp);
        $sourceApp->addAccessor($this);

        return $this;
    }

    /**
     * Remove support for a SourceApp.
     *
     * @param SourceApp $sourceApp
     *
     * @return self
     */
    public function removeSupportedSourceApp(SourceApp $sourceApp): self
    {
        if ($this->supportedSourceApps->contains($sourceApp)) {
            $this->supportedSourceApps->removeElement($sourceApp);
            $sourceApp->removeAccessor($this);
        }

        return $this;
    }

    /**
     * Get the value of supportedSourceQueries.
     *
     * @return Collection
     */
    public function getSupportedSourceQueries()
    {
        return $this->supportedSourceQueries;
    }

    /**
     * Add support for a SourceQuerier.
     *
     * @param SourceQuerier $sourceQuerier
     *
     * @return self
     */
    public function addSupportedSourceQuery(SourceQuerier $sourceQuerier): self
    {
        if ($this->supportedSourceQueries->contains($sourceQuerier)) {
            return $this;
        }

        $this->supportedSourceQueries->add($sourceQuerier);

        return $this;
    }

    /**
     * Remove support for a SourceQuerier.
     *
     * @param SourceQuerier $sourceQuerier
     *
     * @return self
     */
    public function removeSupportedSourceQuery(SourceQuerier $sourceQuerier): self
    {
        if ($this->supportedSourceQueries->contains($sourceQuerier)) {
            $this->supportedSourceQueries->removeElement($sourceQuerier);
        }

        return $this;
    }
}
