<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\GroupsQuery;
use Nokaut\BuybloApiKit\Converter\GroupsConverter;

class GroupsFetch extends Fetch
{
    public function __construct(GroupsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new GroupsConverter(), $cache);
    }
}