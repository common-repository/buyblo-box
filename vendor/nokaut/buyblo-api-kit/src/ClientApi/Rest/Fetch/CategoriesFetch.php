<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\CategoriesQuery;
use Nokaut\BuybloApiKit\Converter\CategoriesConverter;

class CategoriesFetch extends Fetch
{
    public function __construct(CategoriesQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new CategoriesConverter(), $cache);
    }
}