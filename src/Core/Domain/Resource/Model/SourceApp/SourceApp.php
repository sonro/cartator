<?php

namespace App\Core\Domain\Resource\Model\SourceApp;

use App\Core\Domain\Resource\Model\Shared\AbstractDomainEntity;
use App\Core\Domain\SourceAccess\Model\Accessor\Accessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class SourceApp extends AbstractDomainEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $downloadsUrl;

    /**
     * @var bool
     */
    private $autoDownload;

    /**
     * @var Collection
     */
    private $accessors;

    public function __construct()
    {
        $this->accessors = new ArrayCollection();
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
     * Get the value of website.
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set the value of website.
     *
     * @param string $website
     *
     * @return self
     */
    public function setWebsite(string $website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get the value of autoDownload.
     *
     * @return bool
     */
    public function isAutoDownload()
    {
        return $this->autoDownload;
    }

    /**
     * Set the value of autoDownload.
     *
     * @param bool $autoDownload
     *
     * @return self
     */
    public function setAutoDownload(bool $autoDownload)
    {
        $this->autoDownload = $autoDownload;

        return $this;
    }

    /**
     * Get the value of downloadsUrl.
     *
     * @return string
     */
    public function getDownloadsUrl()
    {
        return $this->downloadsUrl;
    }

    /**
     * Set the value of downloadsUrl.
     *
     * @param string $downloadsUrl
     *
     * @return self
     */
    public function setDownloadsUrl(string $downloadsUrl)
    {
        $this->downloadsUrl = $downloadsUrl;

        return $this;
    }

    /**
     * Get the value of accessors.
     *
     * @return Collection
     */
    public function getAccessors()
    {
        return $this->accessors;
    }

    /**
     * Associate an Accesssor with this SourceApp.
     *
     * @param Accessor $accessor
     *
     * @return self
     */
    public function addAccessor(Accessor $accessor)
    {
        if ($this->accessors->contains($accessor)) {
            return;
        }

        $this->accessors->add($accessor);

        $accessor->addSupportedSourceApp($this);

        return $this;
    }

    /**
     * Disassociate an Accessor with this SourceApp.
     *
     * @param Accessor $accessor
     *
     * @return self
     */
    public function removeAccessor(Accessor $accessor)
    {
        if ($this->accessors->contains($accessor)) {
            $this->accessors->removeElement($accessor);
            $accessor->removeSupportedSourceApp($this);
        }

        return $this;
    }
}
