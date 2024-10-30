<?php

namespace Nokaut\BuybloApiKit\Entity\Notification;

use Nokaut\BuybloApiKit\Entity\EntityAbstract;

class Subscription extends EntityAbstract
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $resource_type;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getResourceType()
    {
        return $this->resource_type;
    }

    /**
     * @param string $resource_type
     */
    public function setResourceType($resource_type)
    {
        $this->resource_type = $resource_type;
    }
}