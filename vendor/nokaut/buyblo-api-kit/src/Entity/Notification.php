<?php

namespace Nokaut\BuybloApiKit\Entity;

class Notification extends EntityAbstract
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
     * @var string
     */
    protected $resource_type;

    /**
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @var \Nokaut\BuybloApiKit\Entity\Notification\Subscription[]
     */
    protected $subscriptions = array();

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
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return Notification\Subscription[]
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * @param Notification\Subscription[] $subscriptions
     */
    public function setSubscriptions($subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }
}
