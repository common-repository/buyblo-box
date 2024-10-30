<?php

namespace Nokaut\BuybloApiKit\Repository;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\ClientApiInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Exception\FatalResponseException;
use Nokaut\BuybloApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\BuybloApiKit\Collection\CollectionAbstract;
use Nokaut\BuybloApiKit\Config;
use Nokaut\BuybloApiKit\Entity\EntityAbstract;
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

    /**
     * @param Fetch $fetch
     * @return EntityAbstract
     * @throws FatalResponseException
     */
    protected function fetchOne(Fetch $fetch)
    {
        /** @var CollectionAbstract $collection */
        $collection = $fetch->getResult();

        if (count($collection) > 1) {
            throw new FatalResponseException('Expected single record, fetched: ' . count($collection));
        }

        /** @var EntityAbstract $entity */
        $entity = $collection->getFirst();
        return $entity;
    }
} 