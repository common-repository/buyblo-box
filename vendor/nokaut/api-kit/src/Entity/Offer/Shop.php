<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 07.07.2014
 * Time: 12:42
 */

namespace Nokaut\ApiKitBB\Entity\Offer;


use Nokaut\ApiKitBB\Entity\EntityAbstract;
use Nokaut\ApiKitBB\Entity\Offer\Shop\OpineoRating;

class Shop extends EntityAbstract
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $url_logo;
    /**
     * @var bool
     */
    protected $high_quality;
    /**
     * @var OpineoRating
     */
    protected $opineo_rating;
    /**
     * @var string
     */
    protected $url;

    /**
     * @param boolean $high_quality
     */
    public function setHighQuality($high_quality)
    {
        $this->high_quality = $high_quality;
    }

    /**
     * @return boolean
     */
    public function getHighQuality()
    {
        return $this->high_quality;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Nokaut\ApiKitBB\Entity\Offer\Shop\OpineoRating $opineo_rating
     */
    public function setOpineoRating($opineo_rating)
    {
        $this->opineo_rating = $opineo_rating;
    }

    /**
     * @return \Nokaut\ApiKitBB\Entity\Offer\Shop\OpineoRating
     */
    public function getOpineoRating()
    {
        return $this->opineo_rating;
    }

    /**
     * @param string $url_logo
     */
    public function setUrlLogo($url_logo)
    {
        $this->url_logo = $url_logo;
    }

    /**
     * @return string
     */
    public function getUrlLogo()
    {
        return $this->url_logo;
    }

    /**
     * @return string
     */
    public function getShopUrl()
    {
        return $this->shop_url;
    }

    /**
     * @param string $shop_url
     */
    public function setShopUrl($shop_url)
    {
        $this->shop_url = $shop_url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function __clone()
    {
        if (is_object($this->opineo_rating)) {
            $this->opineo_rating = clone $this->opineo_rating;
        }
    }
}