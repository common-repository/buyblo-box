<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\Subscription;

class SubscriptionConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Subscription
     */
    public function convert(\stdClass $object)
    {
        $subscription = new Subscription();

        foreach ($object as $field => $value) {
            if (!is_object($value) && !is_array($value)) {
                switch ($field) {
                    case 'created_at':
                        $subscription->setCreatedAt(new \DateTime($value));
                        break;
                    default:
                        $subscription->set($field, $value);
                        break;
                }
            }
        }

        return $subscription;
    }
}