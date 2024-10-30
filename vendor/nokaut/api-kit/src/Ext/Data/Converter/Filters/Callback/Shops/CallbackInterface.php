<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\Shops;


use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Shops;

interface CallbackInterface
{

    /**
     * @param Shops $shops
     * @param Products $products
     * @return
     */
    public function __invoke(Shops $shops, Products $products);
}