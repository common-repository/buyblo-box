<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\SubscriptionsQuery;
use Nokaut\BuybloApiKit\Converter\SubscriptionEditResponseConverter;

class SubscriptionEditFetch extends Fetch
{
    /**
     * @param SubscriptionsQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(SubscriptionsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new SubscriptionEditResponseConverter(), $cache);
    }
}
