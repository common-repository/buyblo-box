<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 23.09.2014
 * Time: 15:11
 */

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\OfferQuery;
use Nokaut\ApiKitBB\Converter\OfferConverter;

class OfferFetch extends Fetch
{

    public function __construct(OfferQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new OfferConverter(), $cache);
    }

} 