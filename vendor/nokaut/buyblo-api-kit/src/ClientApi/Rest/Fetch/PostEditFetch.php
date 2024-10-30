<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\PostsQuery;
use Nokaut\BuybloApiKit\Converter\PostEditResponseConverter;

class PostEditFetch extends Fetch
{
    /**
     * @param PostsQuery $query
     * @param CacheInterface $cache
     */
    public function __construct(PostsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new PostEditResponseConverter(), $cache);
    }
}
