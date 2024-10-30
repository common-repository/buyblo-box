<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Categories;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Categories;

class SetIsActive implements CallbackInterface
{
    /**
     * @param Categories $categories
     * @param Products $products
     */
    public function __invoke(Categories $categories, Products $products)
    {
        $this->setCategoriesIsActive($categories);
    }

    /**
     * @param Categories $categories
     */
    protected function setCategoriesIsActive(Categories $categories)
    {
        $countSelectedFilters = $this->countSelectedFiltersEntities($categories);
        if ($countSelectedFilters > 0 and $countSelectedFilters < $categories->count()) {
            $categories->setIsActive(true);
            return;
        }

        $categories->setIsActive(false);
    }

    /**
     * @param Categories $categories
     * @return int
     */
    public function countSelectedFiltersEntities(Categories $categories)
    {
        return count(array_filter($categories->getEntities(), function ($entity) {
            return $entity->getIsFilter();
        }));
    }
}