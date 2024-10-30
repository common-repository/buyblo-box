<?php

namespace Nokaut\ApiKitBB\Converter;


use Nokaut\ApiKitBB\Converter\Shop\OpineoRatingConverter;
use Nokaut\ApiKitBB\Entity\Shop;

class ShopConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $shop = new Shop();
        foreach ($object as $field => $value) {
            if (is_object($value) || is_array($value)) {
                $this->convertSubObject($shop, $field, $value);
            } else {
                $shop->set($field, $value);
            }
        }

        return $shop;
    }

    protected function convertSubObject(Shop $shop, $filed, $value)
    {
        switch ($filed) {
            case 'opineo_rating':
                $opineoRatingConverter = new OpineoRatingConverter();
                $shop->setOpineoRating($opineoRatingConverter->convert($value));
                break;
        }
    }
}