<?php

namespace Nokaut\BuybloApiKit\Entity;


class Category extends EntityAbstract
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $top_url;

    /**
     * @var int
     */
    protected $subscribers_count;

    /**
     * @var string
     */
    protected $subscription_id;

    /**
     * @var int
     */
    protected $groups_count;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getTopUrl()
    {
        return $this->top_url;
    }

    /**
     * @param string $top_url
     */
    public function setTopUrl($top_url)
    {
        $this->top_url = $top_url;
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
     * @return int
     */
    public function getGroupsCount()
    {
        return $this->groups_count;
    }

    /**
     * @param int $groups_count
     */
    public function setGroupsCount($groups_count)
    {
        $this->groups_count = $groups_count;
    }
}