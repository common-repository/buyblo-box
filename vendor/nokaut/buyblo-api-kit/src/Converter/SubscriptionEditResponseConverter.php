<?php

namespace Nokaut\BuybloApiKit\Converter;


class SubscriptionEditResponseConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return string
     */
    public function convert(\stdClass $object)
    {
        if (isset($object->subscription)) {
            if (isset($object->subscription->id)) {
                return $object->subscription->id;
            }
        }
    }
}