<?php

namespace Nokaut\ApiKitBB\Entity\Product\Shop;

use Nokaut\ApiKitBB\Entity\EntityAbstract;

class OpineoRating extends EntityAbstract
{
    /**
     * @var float
     */
    protected $rating;
    /**
     * @var int
     */
    protected $rating_count;
    /**
     * @var string
     */
    protected $url;

    /**
     * @param float $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating_count
     */
    public function setRatingCount($rating_count)
    {
        $this->rating_count = $rating_count;
    }

    /**
     * @return int
     */
    public function getRatingCount()
    {
        return $this->rating_count;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getRatingStar()
    {
        return round($this->rating / 2);
    }
}