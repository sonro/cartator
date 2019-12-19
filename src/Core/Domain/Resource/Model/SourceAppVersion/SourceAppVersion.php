<?php

namespace App\Core\Domain\Resource\Model\SourceAppVersion;

use App\Core\Domain\Shared\Model\AbstractStampableDomainEntity;
use App\Core\Domain\Resource\Model\SourceApp\SourceApp;

class SourceAppVersion extends AbstractStampableDomainEntity
{
    /**
     * @var SourceApp
     */
    private $sourceApp;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $downloadUrl;

    /**
     * Get the value of version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the value of version.
     *
     * @param string $version
     *
     * @return self
     */
    public function setVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get the value of downloadUrl.
     *
     * @return string
     */
    public function getDownloadUrl()
    {
        return $this->downloadUrl;
    }

    /**
     * Set the value of downloadUrl.
     *
     * @param string $downloadUrl
     *
     * @return self
     */
    public function setDownloadUrl(string $downloadUrl)
    {
        $this->downloadUrl = $downloadUrl;

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
}
