<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\PriceRanges;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\PriceRange;
use Nokaut\ApiKitBB\Ext\Lib\ProductsAnalyzer;

class SetIsNofollow implements CallbackInterface
{
    /**
     * @param PriceRanges $priceRanges
     * @param Products $products
     */
    public function __invoke(PriceRanges $priceRanges, Products $products)
    {
        $this->setPriceRangesNofollow($priceRanges, $products);
    }

    /**
     * @param PriceRanges $priceRanges
     */
    protected function setPriceRangesNofollow(PriceRanges $priceRanges, Products $products)
    {
        $countOtherGroupsWithFilterSet = ProductsAnalyzer::countGroupsWithFilterSet($products, $priceRanges);

        foreach ($priceRanges as $priceRange) {
            /** @var PriceRange $priceRange */
            if ($priceRange->getIsFilter() and $countOtherGroupsWithFilterSet == 0) {
                $priceRange->setIsNofollow(false);
            } else {
                $priceRange->setIsNofollow(true);
            }
        }
    }
}