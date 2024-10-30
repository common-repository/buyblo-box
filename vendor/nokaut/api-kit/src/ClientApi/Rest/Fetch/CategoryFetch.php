<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:23
 */

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\CategoryQuery;
use Nokaut\ApiKitBB\Converter\CategoryConverter;

class CategoryFetch extends Fetch
{

    public function __construct(CategoryQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new CategoryConverter(), $cache);
    }
}