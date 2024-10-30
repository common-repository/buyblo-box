<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 14:09
 */

namespace Nokaut\ApiKitBB\Converter\Metadata\Facet;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Metadata\Facet\ProducerFacet;

class ProducerFacetConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $producerFacet = new ProducerFacet();

        foreach ($object as $field => $value) {
            $producerFacet->set($field, $value);
        }
        return $producerFacet;
    }
}