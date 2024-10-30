<?php

namespace Nokaut\ApiKitBB\Converter;


use Nokaut\ApiKitBB\Entity\Producer;

class ProducerConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $producer = new Producer();
        foreach ($object as $field => $value) {
            $producer->set($field, $value);
        }

        return $producer;
    }
}