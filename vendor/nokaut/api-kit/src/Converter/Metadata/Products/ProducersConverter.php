<?php

namespace Nokaut\ApiKitBB\Converter\Metadata\Products;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Metadata\Products\Producers;

class ProducersConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Producers
     */
    public function convert(\stdClass $object)
    {
        $producers = new Producers();

        foreach ($object as $field => $value) {
            $producers->set($field, $value);
        }
        return $producers;
    }
}