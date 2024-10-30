<?php

namespace Nokaut\BuybloApiKit\Converter;


use Nokaut\BuybloApiKit\Entity\Status;

class StatusConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Status
     */
    public function convert(\stdClass $object)
    {
        $status = new Status();
        $status->setAccessToken($object->access_token);
        return $status;
    }
}