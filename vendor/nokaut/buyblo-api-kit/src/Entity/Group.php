<?php

namespace Nokaut\BuybloApiKit\Entity;

class Group extends EntityAbstract
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Product[]
     */
    protected $products = array();

    /**
     * @var int
     */
    protected $numberOfProductsSetManual;

    /**
     * @var int
     */
    protected $numberOfProductsSetAuto;

    /**
     * @var Post[]
     */
    protected $posts = array();

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
        $this->setCounters();
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

    /**
     * @return Post[]
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param Post[] $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    private function setCounters()
    {
        $this->numberOfProductsSetManual = 0;
        $this->numberOfProductsSetAuto = 0;

        foreach ($this->getProducts() as $product) {
            $product->isManual() ? $this->numberOfProductsSetManual++ : $this->numberOfProductsSetAuto++;
        }
    }
}