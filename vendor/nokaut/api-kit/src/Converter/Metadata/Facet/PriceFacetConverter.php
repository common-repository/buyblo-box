<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 14:29
 */

namespace Nokaut\ApiKitBB\Converter\Metadata\Facet;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\PriceFacet;

class PriceFacetConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $priceFacet = new PriceFacet();

        foreach ($object as $field => $value) {
            $priceFacet->set($field, $value);
        }
        return $priceFacet;
    }
}