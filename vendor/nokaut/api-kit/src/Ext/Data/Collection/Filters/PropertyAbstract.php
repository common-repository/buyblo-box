<?php

namespace Nokaut\ApiKitBB\Ext\Data\Collection\Filters;

abstract class PropertyAbstract extends FiltersWithUrlsAbstract
{
    /**
     * @return bool
     */
    public function isPropertyRanges()
    {
        return $this instanceof PropertyRanges;
    }

    /**
     * @return bool
     */
    public function isPropertyValues()
    {
        return $this instanceof PropertyValues;
    }
} 