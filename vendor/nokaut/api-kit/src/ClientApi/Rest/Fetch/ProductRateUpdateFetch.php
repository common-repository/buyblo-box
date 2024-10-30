<?php

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProductRateQuery;
use Nokaut\ApiKitBB\Converter\Product\RatingCreateConverter;

class ProductRateUpdateFetch extends Fetch
{
    /**
     * @param ProductRateQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(ProductRateQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new RatingCreateConverter(), $cache);
    }
}