<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\NotificationsQuery;
use Nokaut\BuybloApiKit\Converter\NotificationsConverter;

class NotificationsFetch extends Fetch
{
    public function __construct(NotificationsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new NotificationsConverter(), $cache);
    }
}