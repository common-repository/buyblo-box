<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\Notification;

class NotificationConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Notification
     */
    public function convert(\stdClass $object)
    {
        $notification = new Notification();

        foreach ($object as $field => $value) {
            if (!is_object($value) && !is_array($value)) {
                switch ($field) {
                    case 'created_at':
                        $notification->setCreatedAt(new \DateTime($value));
                        break;
                    default:
                        $notification->set($field, $value);
                        break;
                }
            } else {
                switch ($field) {
                    case 'subscriptions':
                        $notification->setSubscriptions($this->convertSubscriptions($value));
                        break;
                }
            }
        }

        return $notification;
    }

    /**
     * @param array $objectSubscriptions
     * @return Notification\Subscription[]
     */
    private function convertSubscriptions(array $objectSubscriptions)
    {
        $subscriptions = array();
        foreach ($objectSubscriptions as $object) {
            $subscription = new Notification\Subscription();
            $subscription->setId($object->id);
            $subscription->setResourceType($object->resource_type);

            $subscriptions [] = $subscription;
        }

        return $subscriptions;
    }
}