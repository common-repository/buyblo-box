<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 10:22
 */

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\CategoriesQuery;
use Nokaut\ApiKitBB\Converter\CategoriesConverter;

class CategoriesFetch extends Fetch
{

    public function __construct(CategoriesQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new CategoriesConverter(), $cache);
    }
}