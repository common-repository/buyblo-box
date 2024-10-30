<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 12:55
 */

namespace Nokaut\ApiKitBB\Converter\Offer;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Converter\Offer\Shop\OpineoRatingConverter;
use Nokaut\ApiKitBB\Entity\Offer\Shop;

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