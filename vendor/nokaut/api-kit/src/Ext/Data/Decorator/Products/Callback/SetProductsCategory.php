<?php


namespace Nokaut\ApiKitBB\Ext\Data\Decorator\Products\Callback;


use Nokaut\ApiKitBB\Collection\Categories;
use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Entity\Category;
use Nokaut\ApiKitBB\Entity\Product;

class SetProductsCategory implements CallbackInterface
{
    /**
     * @var Category[]
     */
    private $categoriesById = array();

    /**
     * @param Categories $categories
     */
    function __construct(Categories $categories)
    {
        $this->setCategories($categories);
    }

    public function __invoke(Products $products)
    {
        /** @var $product Product */
        foreach ($products as $product) {
            $category = $this->getCategory($product->getCategoryId());
            if ($category) {
                $product->setCategory($category);
            }
        }
    }

    /**
     * @param Categories $categories
     */
    private function setCategories(Categories $categories)
    {
        /** @var $category Category */
        foreach ($categories as $category) {
            $this->categoriesById[$category->getId()] = $category;
        }
    }

    /**
     * @param $categoryId
     * @return Category
     */
    private function getCategory($categoryId)
    {
        if (isset($this->categoriesById[$categoryId])) {
            return $this->categoriesById[$categoryId];
        }
    }
}