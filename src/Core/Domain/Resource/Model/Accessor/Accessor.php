<?php

namespace App\Core\Domain\Resource\Model\Accessor;

use App\Core\Domain\Resource\Model\Shared\AbstractDomainEntity;
use App\Core\Domain\Resource\Model\SourceApp\SourceApp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Accessor extends AbstractDomainEntity
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
     * @var array
     */
    private $supportedDataTypes;

    /**
     * @var Collection
     */
    private $supportedSourceApps;

    public function __construct()
    {
        $this->supportedSourceApps = new ArrayCollection();
        $this->supportedDataTypes = [];
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

    /**
     * Get the value of supportedDataTypes.
     *
     * @return array
     */
    public function getSupportedDataTypes()
    {
        return $this->supportedDataTypes;
    }

    /**
     * Set the value of supportedDataTypes.
     *
     * @param array $supportedDataTypes
     *
     * @return self
     */
    public function setSupportedDataTypes(array $supportedDataTypes)
    {
        $this->supportedDataTypes = $supportedDataTypes;

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
     * Associate a SourceApp with this Accessor.
     *
     * @param SourceApp $sourceApp
     *
     * @return self
     */
    public function addSupportedSourceApp(SourceApp $sourceApp)
    {
        if ($this->supportedSourceApps->contains($sourceApp)) {
            return;
        }

        $this->supportedSourceApps->add($sourceApp);
        $sourceApp->addAccessor($this);

        return self;
    }

    /**
     * Disassociate a SourceApp with this Accessor.
     *
     * @param SourceApp $sourceApp
     *
     * @return self
     */
    public function removeSupportedSourceApp(SourceApp $sourceApp)
    {
        if ($this->supportedSourceApps->contains($sourceApp)) {
            $this->supportedSourceApps->removeElement($sourceApp);
            $sourceApp->removeAccessor($this);
        }

        return self;
    }
}
