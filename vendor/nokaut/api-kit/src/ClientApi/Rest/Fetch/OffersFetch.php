<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 21.07.2014
 * Time: 13:12
 */

namespace Nokaut\ApiKitBB\ClientApi\Rest\Fetch;


use Nokaut\ApiKitBB\Cache\CacheInterface;
use Nokaut\ApiKitBB\ClientApi\Rest\Query\OffersQuery;
use Nokaut\ApiKitBB\Converter\OffersConverter;

class OffersFetch extends Fetch
{

    public function __construct(OffersQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new OffersConverter(), $cache);
    }

} 