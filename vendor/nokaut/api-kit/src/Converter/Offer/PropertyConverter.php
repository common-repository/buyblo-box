<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 13:00
 */

namespace Nokaut\ApiKitBB\Converter\Offer;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Offer\Property;

class PropertyConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $property = new Property();
        foreach ($object as $field => $value) {
            $property->set($field, $value);
        }
        return $property;
    }

} 