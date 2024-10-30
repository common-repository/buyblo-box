<?php

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProductRatesQuery;
use Nokaut\ApiKitBB\Converter\Product\RatingConverter;

class ProductRatesFetch extends Fetch
{
    /**
     * @param ProductRatesQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(ProductRatesQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new RatingConverter(), $cache);
    }
}