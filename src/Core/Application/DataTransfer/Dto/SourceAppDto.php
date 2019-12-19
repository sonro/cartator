<?php

namespace App\Core\Application\DataTransfer\Dto;

final class SourceAppDto
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

    public function __construct(
        string $name,
        string $website,
        string $downloadsUrl,
        bool $autoDownload
    ) {
        $this->name = $name;
        $this->website = $website;
        $this->downloadsUrl = $downloadsUrl;
        $this->autoDownload = $autoDownload;
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
     * Get the value of website.
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
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
     * Get the value of autoDownload.
     *
     * @return bool
     */
    public function getAutoDownload()
    {
        return $this->autoDownload;
    }
}
