<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:21
 */

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKitBB\Converter\ProductsConverter;

class ProductsFetch extends Fetch
{

    public function __construct(ProductsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new ProductsConverter(), $cache);
    }
}