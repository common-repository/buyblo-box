<?php

namespace BuybloBox\Utils\ProductsSearch;

use Nokaut\ApiKitBB\Collection\Categories;

class InitData
{
    /**
     * @var Categories
     */
    private $categoriesRoot;

    /**
     * @return Categories
     */
    public function getCategoriesRoot()
    {
        return $this->categoriesRoot;
    }

    /**
     * @param Categories $categoriesRoot
     */
    public function setCategoriesRoot(Categories $categoriesRoot)
    {
        $this->categoriesRoot = $categoriesRoot;
    }
}