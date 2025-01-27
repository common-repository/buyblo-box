<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Query\Filter;


interface FilterInterface
{
    /**
     * Unique object hash
     *
     * @return string
     */
    public function toHash();

    /**
     * @return string
     */
    public function __toString();
}