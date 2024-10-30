<?php

namespace Nokaut\BuybloApiKit\ClientApi\Rest\Fetch;


use Nokaut\BuybloApiKit\Cache\CacheInterface;
use Nokaut\BuybloApiKit\ClientApi\Rest\Query\PostsQuery;
use Nokaut\BuybloApiKit\Converter\PostsConverter;

class PostsFetch extends Fetch
{
    public function __construct(PostsQuery $query, CacheInterface $cache)
    {
        parent::__construct($query, new PostsConverter(), $cache);
    }
}
