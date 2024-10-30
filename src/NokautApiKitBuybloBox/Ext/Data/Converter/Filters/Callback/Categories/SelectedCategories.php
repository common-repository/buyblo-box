<?php

namespace NokautApiKitBuybloBox\Ext\Data\Converter\Filters\Callback\Categories;


use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Categories\CallbackInterface;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\Category;

class SelectedCategories implements CallbackInterface
{
    /**
     * @param Categories $categories
     * @param Products $products
     */
    public function __invoke(Categories $categories, Products $products)
    {
        $categoriesArray = $categories->getEntities();

        $categoriesArray = array_filter($categoriesArray, function($entity) use ($products) {
            /** @var Category $entity */
            return $entity->getIsFilter();
        });

        $categories->setEntities($categoriesArray);
    }

}