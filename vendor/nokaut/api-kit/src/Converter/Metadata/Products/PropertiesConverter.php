<?php

namespace Nokaut\ApiKitBB\Converter\Metadata\Products;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Metadata\Products\Properties;

class PropertiesConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Properties
     */
    public function convert(\stdClass $object)
    {
        $properties = new Properties();

        foreach ($object as $field => $value) {
            $properties->set($field, $value);
        }
        return $properties;
    }
}