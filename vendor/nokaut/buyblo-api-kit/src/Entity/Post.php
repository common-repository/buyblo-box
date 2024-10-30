<?php

namespace Nokaut\BuybloApiKit\Entity;

use Nokaut\BuybloApiKit\Entity\Post\Photo;

class Post extends EntityAbstract
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $external_id;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $external_url;

    /**
     * @var string
     */
    protected $redirect_url;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $excerpt;

    /**
     * @var string
     */
    protected $excerpt_short;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var Photo
     */
    protected $photo;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var \Datetime
     */
    protected $post_date;

    /**
     * @var bool
     */
    protected $visibility;

    /**
     * @var bool
     */
    protected $external_visibility;

    /**
     * @var Group[]
     */
    protected $groups = array();

    /**
     * @var bool
     */
    protected $external_change_allowed = false;

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
    protected $numberOfProductsSetManual;

    /**
     * @var int
     */
    protected $numberOfProductsSetAuto;

    /**
     * @var \DateTime
     */
    protected $visibility_at;

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
     * @return string
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * @param string $external_id
     */
    public function setExternalId($external_id)
    {
        $this->external_id = $external_id;
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
    public function getExternalUrl()
    {
        return $this->external_url;
    }

    /**
     * @param string $external_url
     */
    public function setExternalUrl($external_url)
    {
        $this->external_url = $external_url;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirect_url;
    }

    /**
     * @param string $redirect_url
     */
    public function setRedirectUrl($redirect_url)
    {
        $this->redirect_url = $redirect_url;
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
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * @param string $excerpt
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
    }

    /**
     * @return string
     */
    public function getExcerptShort()
    {
        return $this->excerpt_short;
    }

    /**
     * @param string $excerpt_short
     */
    public function setExcerptShort($excerpt_short)
    {
        $this->excerpt_short = $excerpt_short;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param Photo $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \Datetime
     */
    public function getPostDate()
    {
        return $this->post_date;
    }

    /**
     * @param \Datetime $post_date
     */
    public function setPostDate($post_date)
    {
        $this->post_date = $post_date;
    }

    /**
     * @return bool
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param bool $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return bool
     */
    public function getExternalVisibility()
    {
        return $this->external_visibility;
    }

    /**
     * @param bool $external_visibility
     */
    public function setExternalVisibility($external_visibility)
    {
        $this->external_visibility = $external_visibility;
    }

    /**
     * @return Group[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param Group[] $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
        $this->setCounters();
    }

    /**
     * @return bool
     */
    public function isExternalChangeAllowed()
    {
        return $this->external_change_allowed;
    }

    /**
     * @param bool $external_change_allowed
     */
    public function setExternalChangeAllowed($external_change_allowed)
    {
        $this->external_change_allowed = $external_change_allowed;
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
    public function getNumberOfProductsSetManual()
    {
        return $this->numberOfProductsSetManual;
    }

    /**
     * @return int
     */
    public function getNumberOfProductsSetAuto()
    {
        return $this->numberOfProductsSetAuto;
    }

    private function setCounters()
    {
        $this->numberOfProductsSetManual = 0;
        $this->numberOfProductsSetAuto = 0;

        foreach ($this->getGroups() as $group) {
            $this->numberOfProductsSetManual += $group->getNumberOfProductsSetManual();
            $this->numberOfProductsSetAuto += $group->getNumberOfProductsSetAuto();
        }
    }

    /**
     * @return \DateTime
     */
    public function getVisibilityAt()
    {
        return $this->visibility_at;
    }

    /**
     * @param \DateTime $visibility_at
     */
    public function setVisibilityAt(\DateTime $visibility_at)
    {
        $this->visibility_at = $visibility_at;
    }

}