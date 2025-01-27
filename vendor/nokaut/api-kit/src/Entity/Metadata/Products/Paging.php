<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 10.07.2014
 * Time: 14:20
 */

namespace Nokaut\ApiKitBB\Entity\Metadata\Products;


use Nokaut\ApiKitBB\Entity\EntityAbstract;

class Paging extends EntityAbstract
{
    /**
     * @var int
     */
    protected $current;
    /**
     * @var int
     */
    protected $total;
    /**
     * @var string
     */
    protected $url_template;
    /**
     * @var string
     */
    protected $url_first_page;

    /**
     * @param int $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * @return int
     */
    public function getCurrent()
    {
        return $this->current;
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
     * @param string $url_template
     */
    public function setUrlTemplate($url_template)
    {
        $this->url_template = $url_template;
    }

    /**
     * @return string
     */
    public function getUrlTemplate()
    {
        return $this->url_template;
    }

    /**
     * @return string
     */
    public function getUrlFirstPage()
    {
        return $this->url_first_page;
    }

    /**
     * @param string $url_first_page
     */
    public function setUrlFirstPage($url_first_page)
    {
        $this->url_first_page = $url_first_page;
    }

}