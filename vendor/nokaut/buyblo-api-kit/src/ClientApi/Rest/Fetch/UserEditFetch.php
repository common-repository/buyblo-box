<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 13.04.2017
 * Time: 10:42
 */

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\UsersQuery;
use Nokaut\BuybloApiKit\Converter\UserEditResponseConverter;

class UserEditFetch extends Fetch
{
    /**
     * @param UsersQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(UsersQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new UserEditResponseConverter(), $cache);
    }
}