<?php


namespace Nokaut\ApiKitBB\Ext\Data\Decorator\Products\Callback;


use Nokaut\ApiKitBB\Collection\Products;

interface CallbackInterface
{
    public function __invoke(Products $products);
} 