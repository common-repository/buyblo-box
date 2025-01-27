<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 27.06.2014
 * Time: 09:11
 */

namespace Nokaut\ApiKitBB\Converter\Product;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Converter\Product\Shop\OpineoRatingConverter;
use Nokaut\ApiKitBB\Entity\Product\Shop;

class ShopConverter implements ConverterInterface {

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

    private function convertSubObject(Shop $shop, $filed, $value)
    {
        switch ($filed) {
            case 'opineo_rating':
                $opineoRatingConverter = new OpineoRatingConverter();
                $shop->setOpineoRating($opineoRatingConverter->convert($value));
                break;
        }
    }
}