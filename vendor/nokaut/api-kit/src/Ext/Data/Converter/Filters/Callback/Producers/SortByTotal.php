<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Producers;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Producers;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Sort;

class SortByTotal implements CallbackInterface
{
    /**
     * @param Producers $producers
     * @param Products $products
     */
    public function __invoke(Producers $producers, Products $products)
    {
        Sort\SortByTotal::sort($producers);
    }
}