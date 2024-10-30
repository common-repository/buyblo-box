<?php


namespace Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Selected;

use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Ext\Data\Converter\Filters\Callback\PriceRanges\CallbackInterface;
use Nokaut\ApiKitBB\Ext\Data\Converter\Filters\PriceRangesConverter as PriceRangesConverterParent;
use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\PriceRanges;
use Nokaut\ApiKitBB\Ext\Data\Entity\Filter\PriceRange;

class PriceRangesConverter extends PriceRangesConverterParent
{
    /**
     * @param Products $products
     * @param CallbackInterface[] $callbacks
     * @return PriceRanges
     */
    public function convert(Products $products, $callbacks = array())
    {
        $priceRanges = parent::convert($products, array());

        $priceRanges->setEntities(array_filter($priceRanges->getEntities(), function ($entity) {
            /** @var PriceRange $entity */
            return $entity->getIsFilter();
        }));

        foreach ($callbacks as $callback) {
            $callback($priceRanges, $products);
        }

        return $priceRanges;
    }
}