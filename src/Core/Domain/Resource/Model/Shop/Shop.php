<?php

namespace App\Core\Domain\Resource\Model\Shop;

use App\Core\Domain\Resource\Model\Installation\Installation;
use App\Core\Domain\Resource\Model\Shared\AbstractDomainEntity;

final class Shop extends AbstractDomainEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $shortname;

    /**
     * @var Installation
     */
    private $installation;

    /**
     * @var int
     */
    private $installationShopId;

    /**
     * @var string
     */
    private $url;

    /**
     * @var ShopMeta
     */
    private $shopMeta;

    /**
     * @var bool
     */
    private $active;

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
     * Get the value of shortname.
     *
     * @return string
     */
    public function getShortname()
    {
        return $this->shortname;
    }

    /**
     * Set the value of shortname.
     *
     * @param string $shortname
     *
     * @return self
     */
    public function setShortname(string $shortname)
    {
        $this->shortname = $shortname;

        return $this;
    }

    /**
     * Get the value of installation.
     *
     * @return Installation
     */
    public function getInstallation()
    {
        return $this->installation;
    }

    /**
     * Set the value of installation.
     *
     * @param Installation $installation
     *
     * @return self
     */
    public function setInstallation(Installation $installation)
    {
        $this->installation = $installation;

        return $this;
    }

    /**
     * Get the value of installationShopId.
     *
     * @return int
     */
    public function getInstallationShopId()
    {
        return $this->installationShopId;
    }

    /**
     * Set the value of installationShopId.
     *
     * @param int $installationShopId
     *
     * @return self
     */
    public function setInstallationShopId(int $installationShopId)
    {
        $this->installationShopId = $installationShopId;

        return $this;
    }

    /**
     * Get the value of url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url.
     *
     * @param string $url
     *
     * @return self
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of shopMeta.
     *
     * @return ShopMeta
     */
    public function getShopMeta()
    {
        return $this->shopMeta;
    }

    /**
     * Set the value of shopMeta.
     *
     * @param ShopMeta $shopMeta
     *
     * @return self
     */
    public function setShopMeta(ShopMeta $shopMeta)
    {
        $this->shopMeta = $shopMeta;

        return $this;
    }

    /**
     * Get the value of active.
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active.
     *
     * @param bool $active
     *
     * @return self
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }
}
