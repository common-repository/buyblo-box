<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 26.09.2014
 * Time: 09:09
 */

namespace Nokaut\ApiKitBB\Repository;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\ClientApiInterface;
use Nokaut\ApiKitBB\Config;
use Psr\Log\LoggerInterface;

abstract class RepositoryAbstract
{
    /**
     * @var ClientApiInterface
     */
    protected $clientApi;
    /**
     * @var string
     */
    protected $apiBaseUrl;
    /**
     * @var CacheInterface
     */
    protected $cache;
    /**
     * @var LoggerInterface
     */
    protected $logger;


    /**
     * @param Config $config
     * @param ClientApiInterface $clientApi
     */
    public function __construct(Config $config, ClientApiInterface $clientApi)
    {
        $this->clientApi = $clientApi;
        $this->apiBaseUrl = $config->getApiUrl();
        $this->cache = $config->getCache();
        $this->logger = $config->getLogger();
    }
} 