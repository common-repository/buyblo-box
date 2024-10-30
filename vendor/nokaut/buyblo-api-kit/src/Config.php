<?php

namespace Nokaut\BuybloApiKit;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\Cache\NullCache;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Config
{
    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var string
     */
    protected $apiAccessToken;

    /**
     * @var string
     */
    protected $proxy;

    /**
     * @var array
     */
    protected $headers = array();

    public function __construct()
    {
        $this->setLogger(new NullLogger());
        $this->setCache(new NullCache());
    }

    /**
     * @param string $apiAccessToken
     */
    public function setApiAccessToken($apiAccessToken)
    {
        $this->apiAccessToken = $apiAccessToken;
    }

    /**
     * @return string
     */
    public function getApiAccessToken()
    {
        return $this->apiAccessToken;
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return string
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param string $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * Check if config is correct filled
     * @throws \InvalidArgumentException
     */
    public function validate()
    {
        if (empty($this->apiAccessToken)) {
            throw new \InvalidArgumentException("empty api access token, please set access token for API in Nokaut\\BuybloApiKit\\Config");
        }

        if (empty($this->apiUrl)) {
            throw new \InvalidArgumentException("empty api URL, please set URL to API in Nokaut\\BuybloApiKit\\Config");
        }

        if (empty($this->cache)) {
            throw new \InvalidArgumentException("cache not set, please cache mechanism in Nokaut\\BuybloApiKit\\Config");
        }

        if (empty($this->logger)) {
            throw new \InvalidArgumentException("logger not set, please logger mechanism in Nokaut\\BuybloApiKit\\Config");
        }
    }
} 