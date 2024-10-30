<?php

namespace Nokaut\BuybloApiKit\Entity;


class Subscription extends EntityAbstract
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $user_id;

    /**
     * @var string
     */
    protected $resource_id;

    /**
     * category|post|product|user
     * @var string
     */
    protected $resource_type;

    /**
     * @var \Datetime
     */
    protected $created_at;

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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getResourceId()
    {
        return $this->resource_id;
    }

    /**
     * @param string $resource_id
     */
    public function setResourceId($resource_id)
    {
        $this->resource_id = $resource_id;
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

    /**
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \Datetime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
}
