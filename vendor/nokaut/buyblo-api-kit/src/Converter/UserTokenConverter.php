<?php

namespace Nokaut\BuybloApiKit\Converter;


class UserTokenConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return string
     */
    public function convert(\stdClass $object)
    {
        return $object->token;
    }
}