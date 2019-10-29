<?php

namespace App\Core\Domain\Model\Software;

use App\Core\Domain\Model\Shared\AbstractDomainEntity;

final class Software extends AbstractDomainEntity
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $downloadUrl;

    /**
     * Get the value of application.
     *
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set the value of application.
     *
     * @param Application $application
     *
     * @return self
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;

        return $this;
    }

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
}
