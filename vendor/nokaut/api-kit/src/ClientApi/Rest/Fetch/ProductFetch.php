<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:26
 */

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\ProductQuery;
use Nokaut\ApiKitBB\Converter\ProductConverter;

class ProductFetch extends Fetch
{

    public function __construct(ProductQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new ProductConverter(), $cache);
    }

}