<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\StatusQuery;
use Nokaut\BuybloApiKit\Converter\StatusConverter;

class StatusFetch extends Fetch
{
    public function __construct(StatusQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new StatusConverter(), $cache);
    }
}
