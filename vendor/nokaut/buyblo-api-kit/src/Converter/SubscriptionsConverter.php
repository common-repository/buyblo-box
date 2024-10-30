<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Collection\Subscriptions;
use Nokaut\BuybloApiKit\Entity\Subscriptions\Metadata;

class SubscriptionsConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Subscriptions
     */
    public function convert(\stdClass $object)
    {
        $subscriptionConverter = new SubscriptionConverter();
        $entities = array();
        foreach ($object->subscriptions as $subscriptionObject) {
            $entities[] = $subscriptionConverter->convert($subscriptionObject);
        }

        $subscriptions = new Subscriptions($entities);
        if (isset($object->metadata)) {
            $subscriptions->setMetadata($this->convertMetadata($object->metadata));
        }
        return $subscriptions;
    }

    /**
     * @param $object
     * @return Metadata
     */
    protected function convertMetadata($object)
    {
        $metadata = new Metadata();
        if (isset($object->total)) {
            $metadata->setTotal($object->total);
        }

        return $metadata;
    }
}