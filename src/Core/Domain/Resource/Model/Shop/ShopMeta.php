<?php

namespace App\Core\Domain\Resource\Model\Shop;

class ShopMeta
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    public function __construct($title = '', $description = '')
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the value of title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
