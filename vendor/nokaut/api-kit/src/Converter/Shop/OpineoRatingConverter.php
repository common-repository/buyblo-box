<?php

namespace Nokaut\ApiKitBB\Converter\Shop;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Entity\Shop\OpineoRating;

class OpineoRatingConverter implements ConverterInterface
{
    public function convert(\stdClass $object)
    {
        $opineoRating = new OpineoRating();
        foreach ($object as $field => $value) {
            $opineoRating->set($field, $value);
        }
        return $opineoRating;
    }
}