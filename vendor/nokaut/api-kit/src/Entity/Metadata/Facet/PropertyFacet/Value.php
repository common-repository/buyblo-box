<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 11.07.2014
 * Time: 15:09
 */

namespace Nokaut\ApiKitBB\Entity\Metadata\Facet\PropertyFacet;


use Nokaut\ApiKitBB\Entity\EntityAbstract;

class Value extends EntityAbstract
{
    /**
     * @var string
     */
    protected $name;
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

}
