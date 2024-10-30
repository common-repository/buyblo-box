<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Producers;


use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Producers;

interface CallbackInterface
{

    /**
     * @param Producers $producers
     * @param Products $products
     * @return
     */
    public function __invoke(Producers $producers, Products $products);
}