<?php


namespace Nokaut\ApiKitBB\Ext\Data\Decorator\Products;


use Nokaut\ApiKitBB\Collection\Products;

class ProductsDecorator
{
    public function decorate(Products $products, $callbacks = array())
    {
        foreach ($callbacks as $callback) {
            $callback($products);
        }
    }
}