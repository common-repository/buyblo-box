<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 26.07.2014
 * Time: 09:59
 */

namespace Nokaut\ApiKitBB\Converter\Product;


use Nokaut\ApiKitBB\Converter\ConverterInterface;
use Nokaut\ApiKitBB\Converter\Product\Rating\RateConverter;
use Nokaut\ApiKitBB\Entity\Product\Rating;

class RatingConverter implements ConverterInterface
{
    /**
     * @param \stdClass $object
     * @return Rating
     */
    public function convert(\stdClass $object)
    {
        $rating = new Rating();
        if (isset($object->rating)) {
            $rating->setRating($object->rating);
        }
        if (isset($object->current_rating)) {
            $rating->setRating($object->current_rating);
        }

        $rates = array();
        $rateConverter = new RateConverter();
        if (isset($object->rates) && is_array($object->rates)) {
            foreach ($object->rates as $rawRate) {
                $rates[] = $rateConverter->convert($rawRate);
            }
        }
        $rating->setRates($rates);

        return $rating;
    }
} 