<?php

namespace Nokaut\ApiKitBB\Converter;


use Nokaut\ApiKitBB\Collection\Shops;

class ShopsConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Shops
     */
    public function convert(\stdClass $object)
    {
        $shopConverter = new ShopConverter();
        $shopsArray = array();
        foreach ($object->shops as $shopObject) {
            $shopsArray[] = $shopConverter->convert($shopObject);
        }

        return new Shops($shopsArray);
    }
}