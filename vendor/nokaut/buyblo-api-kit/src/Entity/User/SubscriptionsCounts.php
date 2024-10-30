<?php

namespace Nokaut\BuybloApiKit\Entity\User;

use Nokaut\BuybloApiKit\Entity\EntityAbstract;

class SubscriptionsCounts extends EntityAbstract
{
    /**
     * @var int
     */
    private $post;

    /**
     * @var int
     */
    private $user;

    /**
     * @var int
     */
    private $product;

    /**
     * @var int
     */
    private $category;

    /**
     * @return int
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param int $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param int $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}