<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Property;


use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PropertyAbstract;

interface CallbackInterface
{

    /**
     * @param PropertyAbstract $property
     * @param Products $products
     * @return
     */
    public function __invoke(PropertyAbstract $property, Products $products);
}