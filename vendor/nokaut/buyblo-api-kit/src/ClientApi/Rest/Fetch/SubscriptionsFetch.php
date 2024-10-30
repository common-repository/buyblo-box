<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\SubscriptionsQuery;
use Nokaut\BuybloApiKit\Converter\SubscriptionsConverter;

class SubscriptionsFetch extends Fetch
{
    public function __construct(SubscriptionsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new SubscriptionsConverter(), $cache);
    }
}