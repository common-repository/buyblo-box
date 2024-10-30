<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Categories;


use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Categories;

interface CallbackInterface
{
    /**
     * @param Categories $categories
     * @param Products $products
     * @return
     */
    public function __invoke(Categories $categories, Products $products);
}