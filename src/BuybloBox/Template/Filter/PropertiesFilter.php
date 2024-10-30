<?php

namespace BuybloBox\Template\Filter;

use Nokaut\ApiKitBB\Entity\Product\Property;

class PropertiesFilter
{
    /**
     * @param Property[] $properties
     * @return string
     */
    public static function propertiesFilter(array $properties)
    {
        return array_filter($properties, function (Property $property) {
            return !in_array(strtolower($property->getName()), array('ean'));
        });
    }
}