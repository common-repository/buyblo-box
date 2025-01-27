<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 14.07.2014
 * Time: 09:04
 */

namespace Nokaut\ApiKitBB\Entity;


use Nokaut\ApiKitBB\Entity\Product\OfferWithBestPrice;

class ProductWithBestOffer extends Product
{
    /**
     * @var OfferWithBestPrice
     */
    protected $offer_with_minimum_price;

    /**
     * @param OfferWithBestPrice $offerWithBestPrice
     */
    public function setOfferWithBestPrice($offerWithBestPrice)
    {
        $this->offer_with_minimum_price = $offerWithBestPrice;
    }

    /**
     * @return OfferWithBestPrice
     */
    public function getOfferWithBestPrice()
    {
        return $this->offer_with_minimum_price;
    }

    public function __clone()
    {
        if (is_object($this->offer_with_minimum_price)) {
            $this->offer_with_minimum_price = clone $this->offer_with_minimum_price;
        }
    }
}