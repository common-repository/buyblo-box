<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\UsersQuery;
use Nokaut\BuybloApiKit\Converter\UsersConverter;

class UsersFetch extends Fetch
{
    public function __construct(UsersQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new UsersConverter(), $cache);
    }
}