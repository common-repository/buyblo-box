<?php

namespace BuybloBox\Filter;

use Nokaut\ApiKitBB\Entity\Product\Property;

class PropertiesFilter
{
    /**
     * @param Property[] $properties
     * @return Property[]
     */
    public static function filter(array $properties)
    {
        return array_filter($properties, function (Property $property) {
            return !in_array(strtolower($property->getName()), array('ean'));
        });
    }
}