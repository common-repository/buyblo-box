<?php

namespace Nokaut\ApiKitBB\Entity\Metadata\Facet\PropertyFacet;


use Nokaut\ApiKitBB\Entity\EntityAbstract;

class Range extends EntityAbstract
{
    /**
     * @var int
     */
    protected $min;
    /**
     * @var int
     */
    protected $max;
    /**
     * @var string
     */
    protected $param;
    /**
     * @var int
     */
    protected $total;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var bool
     */
    protected $is_filter = false;

    /**
     * @param boolean $is_filter
     */
    public function setIsFilter($is_filter)
    {
        $this->is_filter = $is_filter;
    }

    /**
     * @return boolean
     */
    public function getIsFilter()
    {
        return $this->is_filter;
    }

    /**
     * @param int $max
     */
    public function setMax($max)
    {
        $this->max = $max;
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param int $min
     */
    public function setMin($min)
    {
        $this->min = $min;
    }

    /**
     * @return int
     */
    public function getMin()
    {
        return $this->min;
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
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
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
}