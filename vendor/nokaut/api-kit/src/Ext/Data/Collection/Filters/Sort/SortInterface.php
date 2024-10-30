<?php


namespace Nokaut\ApiKitBB\Ext\Data\Collection\Filters\Sort;


use Nokaut\ApiKitBB\Ext\Data\Collection\Filters\FiltersAbstract;

interface SortInterface
{
    /**
     * @param FiltersAbstract $filters
     * @return
     */
    public static function sort(FiltersAbstract $filters);
} 