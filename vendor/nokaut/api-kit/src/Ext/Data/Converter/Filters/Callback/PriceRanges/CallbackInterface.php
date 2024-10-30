<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\PriceRanges;


use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PriceRanges;

interface CallbackInterface
{

    /**
     * @param PriceRanges $priceRanges
     * @param Products $products
     * @return
     */
    public function __invoke(PriceRanges $priceRanges, Products $products);
}