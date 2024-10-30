<?php

namespace Nokaut\BuybloApiKit\Entity\Post;

use Nokaut\BuybloApiKit\Entity\EntityAbstract;

class Photo extends EntityAbstract
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var string
     */
    protected $external_url;

    /**
     * @var int
     */
    protected $original_width;

    /**
     * @var int
     */
    protected $original_height;

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

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getExternalUrl()
    {
        return $this->external_url;
    }

    /**
     * @param string $external_url
     */
    public function setExternalUrl($external_url)
    {
        $this->external_url = $external_url;
    }

    /**
     * @return int
     */
    public function getOriginalWidth()
    {
        return $this->original_width;
    }

    /**
     * @param int $original_width
     */
    public function setOriginalWidth($original_width)
    {
        $this->original_width = $original_width;
    }

    /**
     * @return int
     */
    public function getOriginalHeight()
    {
        return $this->original_height;
    }

    /**
     * @param int $original_height
     */
    public function setOriginalHeight($original_height)
    {
        $this->original_height = $original_height;
    }
}