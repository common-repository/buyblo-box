<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 17.06.2014
 * Time: 13:47
 */

namespace Nokaut\ApiKitBB\Entity\Product;


use Nokaut\ApiKitBB\Entity\EntityAbstract;
use Nokaut\ApiKitBB\Entity\Product\Shop\OpineoRating;

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
     * @return OpineoRating
     */
    public function getOpineoRating()
    {
        return $this->opineo_rating;
    }

    /**
     * @param OpineoRating $opineo_rating
     */
    public function setOpineoRating($opineo_rating)
    {
        $this->opineo_rating = $opineo_rating;
    }
} 