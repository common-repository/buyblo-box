<?php

namespace Nokaut\BuybloApiKit\Entity;


use Nokaut\BuybloApiKit\Entity\User\SubscriptionsCounts;

class User extends EntityAbstract
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $pid;

    /**
     * @var string
     */
    protected $region;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $logo_url;

    /**
     * @var string
     */
    protected $logo_template;

    /**
     * @var string
     */
    protected $external_logo_url;

    /**
     * @var int
     */
    protected $logo_original_width;

    /**
     * @var int
     */
    protected $logo_original_height;

    /**
     * @var string
     */
    protected $facebook_url;

    /**
     * @var string
     */
    protected $instagram_url;

    /**
     * @var int
     */
    protected $posts_count;

    /**
     * @var string
     */
    protected $first_name;

    /**
     * @var string
     */
    protected $last_name;

    /**
     * @var string
     */
    protected $website_platform;

    /**
     * @var string
     */
    protected $recommendation_code;

    /**
     * @var int
     */
    protected $subscribers_count;

    /**
     * @var SubscriptionsCounts
     */
    protected $subscriptions_counts;

    /**
     * @var string
     */
    protected $subscription_id;

    /**
     * @var \DateTime
     */
    protected $external_visibility_at;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function getLogoTemplate()
    {
        return $this->logo_template;
    }

    /**
     * @param string $logo_template
     */
    public function setLogoTemplate($logo_template)
    {
        $this->logo_template = $logo_template;
    }

    /**
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->logo_url;
    }

    /**
     * @param string $logo_url
     */
    public function setLogoUrl($logo_url)
    {
        $this->logo_url = $logo_url;
    }

    /**
     * @return string
     */
    public function getExternalLogoUrl()
    {
        return $this->external_logo_url;
    }

    /**
     * @param string $external_logo_url
     */
    public function setExternalLogoUrl($external_logo_url)
    {
        $this->external_logo_url = $external_logo_url;
    }

    /**
     * @return int
     */
    public function getLogoOriginalWidth()
    {
        return $this->logo_original_width;
    }

    /**
     * @param int $logo_original_width
     */
    public function setLogoOriginalWidth($logo_original_width)
    {
        $this->logo_original_width = $logo_original_width;
    }

    /**
     * @return int
     */
    public function getLogoOriginalHeight()
    {
        return $this->logo_original_height;
    }

    /**
     * @param int $logo_original_height
     */
    public function setLogoOriginalHeight($logo_original_height)
    {
        $this->logo_original_height = $logo_original_height;
    }

    /**
     * @return string
     */
    public function getFacebookUrl()
    {
        return $this->facebook_url;
    }

    /**
     * @param string $facebook_url
     */
    public function setFacebookUrl($facebook_url)
    {
        $this->facebook_url = $facebook_url;
    }

    /**
     * @return string
     */
    public function getInstagramUrl()
    {
        return $this->instagram_url;
    }

    /**
     * @param string $instagram_url
     */
    public function setInstagramUrl($instagram_url)
    {
        $this->instagram_url = $instagram_url;
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
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getWebsitePlatform()
    {
        return $this->website_platform;
    }

    /**
     * @param string $website_platform
     */
    public function setWebsitePlatform($website_platform)
    {
        $this->website_platform = $website_platform;
    }

    /**
     * @return string
     */
    public function getRecommendationCode()
    {
        return $this->recommendation_code;
    }

    /**
     * @param string $recommendation_code
     */
    public function setRecommendationCode($recommendation_code)
    {
        $this->recommendation_code = $recommendation_code;
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
     * @return SubscriptionsCounts
     */
    public function getSubscriptionsCounts()
    {
        return $this->subscriptions_counts;
    }

    /**
     * @param SubscriptionsCounts $subscriptions_counts
     */
    public function setSubscriptionsCounts($subscriptions_counts)
    {
        $this->subscriptions_counts = $subscriptions_counts;
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
     * @return \DateTime
     */
    public function getExternalVisibilityAt()
    {
        return $this->external_visibility_at;
    }

    /**
     * @param \DateTime $external_visibility_at
     */
    public function setExternalVisibilityAt(\DateTime $external_visibility_at)
    {
        $this->external_visibility_at = $external_visibility_at;
    }

}