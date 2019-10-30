<?php

namespace App\Core\Domain\Resource\Model\SourceAppVersion;

use App\Core\Domain\Resource\Model\Shared\AbstractDomainEntity;

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
}
