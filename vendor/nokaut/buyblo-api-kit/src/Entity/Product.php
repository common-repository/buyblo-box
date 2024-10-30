<?php

namespace Nokaut\BuybloApiKit\Entity;


class Product extends EntityAbstract
{
    const TYPE_MANUAL = 'manual';
    const TYPE_AUTO = 'auto';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $posts_count;

    /**
     * @var int
     */
    protected $subscribers_count;

    /**
     * @var string
     */
    protected $subscription_id;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getPostsCount()
    {
        return $this->posts_count;
    }

    /**
     * @param int $posts_count
     */
    public function setPostsCount($posts_count)
    {
        $this->posts_count = $posts_count;
    }

    /**
     * @return int
     */
    public function getSubscribersCount()
    {
        return $this->subscribers_count;
    }

    /**
     * @param int $subscribers_count
     */
    public function setSubscribersCount($subscribers_count)
    {
        $this->subscribers_count = $subscribers_count;
    }

    /**
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscription_id;
    }

    /**
     * @param string $subscription_id
     */
    public function setSubscriptionId($subscription_id)
    {
        $this->subscription_id = $subscription_id;
    }

    /**
     * @return bool
     */
    public function isManual()
    {
        return $this->getType() == self::TYPE_MANUAL;
    }
}