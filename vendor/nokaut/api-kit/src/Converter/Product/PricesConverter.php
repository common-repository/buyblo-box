<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.06.2014
 * Time: 08:34
 */

namespace Nokaut\ApiKitBB\Converter\Product;



use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Product\Prices;

class PricesConverter implements ConverterInterface
{

    public function convert(\stdClass $object)
    {
        $prices = new Prices();
        $prices->setMax($object->max);
        $prices->setMin($object->min);

        return $prices;
    }
}