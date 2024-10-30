<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Collection\Notifications;
use Nokaut\BuybloApiKit\Entity\Notifications\Metadata;

class NotificationsConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Notifications
     */
    public function convert(\stdClass $object)
    {
        $notificationConverter = new NotificationConverter();
        $entities = array();
        foreach ($object->notifications as $notificationObject) {
            $entities[] = $notificationConverter->convert($notificationObject);
        }

        $notifications = new Notifications($entities);
        if (isset($object->metadata)) {
            $notifications->setMetadata($this->convertMetadata($object->metadata));
        }
        return $notifications;
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