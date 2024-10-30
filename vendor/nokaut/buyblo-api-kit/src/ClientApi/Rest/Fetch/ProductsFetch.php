<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\BuybloApiKit\Converter\ProductsConverter;

class ProductsFetch extends Fetch
{
    public function __construct(ProductsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new ProductsConverter(), $cache);
    }
}