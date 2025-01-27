<?php

namespace Nokaut\ApiKitBB\Ext\Data\Entity\Filter;


class Shop extends FilterAbstract
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $param;

    /**
     * @var string
     */
    protected $url_base;

    /**
     * @var bool
     */
    protected $is_popular = false;

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
     * @return string
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param string $param
     */
    public function setParam($param)
    {
        $this->param = $param;
    }

    /**
     * @param string $url_base
     */
    public function setUrlBase($url_base)
    {
        $this->url_base = $url_base;
    }

    /**
     * @return string
     */
    public function getUrlBase()
    {
        return $this->url_base;
    }

    /**
     * @param boolean $is_popular
     */
    public function setIsPopular($is_popular)
    {
        $this->is_popular = $is_popular;
    }

    /**
     * @return boolean
     */
    public function getIsPopular()
    {
        return $this->is_popular;
    }
} 