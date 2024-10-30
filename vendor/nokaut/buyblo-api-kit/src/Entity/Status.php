<?php

namespace Nokaut\BuybloApiKit\Entity;

class Status extends EntityAbstract
{
    /**
     * @var string
     */
    protected $access_token;

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }
}