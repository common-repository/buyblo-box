<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter;

class Single implements FilterInterface
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $key
     * @param string $value
     */
    function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toHash()
    {
        return md5($this->key);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("filter[%s]=%s", $this->key, urlencode($this->value));
    }
} 