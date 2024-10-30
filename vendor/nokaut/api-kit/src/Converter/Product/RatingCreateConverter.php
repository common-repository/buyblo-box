<?php

namespace Nokaut\ApiKitBB\Converter\Product;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Converter\Product\Rating\RateConverter;
use Nokaut\ApiKitBB\Entity\Product\Rating;

class RatingCreateConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Rating
     */
    public function convert(\stdClass $object)
    {
        $rating = new Rating();

        if (isset($object->current_rating)) {
            $rating->setRating($object->current_rating);
        }

        $rateConverter = new RateConverter();
        $rating->setRates(array($rateConverter->convert($object)));

        return $rating;
    }
}