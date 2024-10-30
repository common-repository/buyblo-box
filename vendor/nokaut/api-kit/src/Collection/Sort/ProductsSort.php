<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 27.06.2014
 * Time: 10:35
 */

namespace Nokaut\ApiKitBB\Collection\Sort;


use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\ApiKitBB\Entity\Product;

class ProductsSort extends SortAbstract
{
    /**
     * @param Products $collection
     * @param int $sorting
     */
    public static function sortByPriceMin(Products $collection, $sorting = SORT_ASC)
    {
        self::sortBy($collection,
            function (Product $product) {
                return $product->getPrices()->getMin();
            }, $sorting);
    }
} 