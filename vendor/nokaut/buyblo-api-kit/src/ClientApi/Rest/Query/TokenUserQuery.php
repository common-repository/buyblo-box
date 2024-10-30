<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Query;


class TokenUserQuery extends QueryAbstract
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $userId;


    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function createRequestPath()
    {
        return $this->baseUrl . 'users/' . $this->userId . '/token';
    }
}