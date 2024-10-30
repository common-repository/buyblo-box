<?php

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProducersQuery;
use Nokaut\ApiKitBB\Converter\ProducersConverter;

class ProducersFetch extends Fetch
{
    /**
     * @param ProducersQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(ProducersQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new ProducersConverter(), $cache);
    }
}