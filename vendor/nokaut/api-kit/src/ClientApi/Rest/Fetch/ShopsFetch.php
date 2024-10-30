<?php

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ShopsQuery;
use Nokaut\ApiKitBB\Converter\ShopsConverter;

class ShopsFetch extends Fetch
{
    /**
     * @param ShopsQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(ShopsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new ShopsConverter(), $cache);
    }
}