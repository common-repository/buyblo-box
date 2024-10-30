<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 15:13
 */

namespace Nokaut\ApiKitBB\Converter\Metadata\Facet\PropertyFacet;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\PropertyFacet\Value;

class ValueConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $valueEntity = new Value();

        foreach ($object as $field => $value) {
            $valueEntity->set($field, $value);
        }
        return $valueEntity;
    }
}