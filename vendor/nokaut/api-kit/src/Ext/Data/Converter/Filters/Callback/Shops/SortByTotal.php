<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Shops;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Shops;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Sort;

class SortByTotal implements CallbackInterface
{
    /**
     * @param Shops $shops
     * @param Products $products
     */
    public function __invoke(Shops $shops, Products $products)
    {
        Sort\SortByTotal::sort($shops);
    }
}