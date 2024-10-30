<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Categories;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Categories;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Sort;

class SortByName implements CallbackInterface
{
    /**
     * @param Categories $categories
     * @param Products $products
     */
    public function __invoke(Categories $categories, Products $products)
    {
        Sort\SortByName::sort($categories);
    }
}